<?php

namespace App\Models;

use CodeIgniter\Model;

class ParkirModel extends Model
{
    protected $table = 'parkir';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_parkir', 'qr_code', 'qr_base64', 'waktu_masuk', 'waktu_keluar', 
        'durasi_menit', 'biaya', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Hitung jumlah transaksi hari ini
     */
    public function countTodayTransactions()
    {
        return $this->where('DATE(waktu_masuk)', date('Y-m-d'))->countAllResults();
    }

    /**
     * Ambil data parkir berdasarkan ID Parkir
     */
    public function getByIdParkir($idParkir)
    {
        return $this->where('id_parkir', $idParkir)->first();
    }

    /**
     * Ambil semua parkir yang masih aktif
     */
    public function getAktifParkir()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('waktu_masuk', 'DESC')
                    ->findAll();
    }

    /**
     * Checkout parkir
     */
    public function checkoutParkir($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Laporan berdasarkan periode
     */
    public function getLaporan($startDate, $endDate, $groupBy = 'daily')
    {
        $builder = $this->builder();
        
        $builder->select('DATE(waktu_masuk) as tanggal, COUNT(*) as total_transaksi, SUM(biaya) as total_pendapatan')
                ->where('waktu_masuk >=', $startDate)
                ->where('waktu_masuk <=', $endDate)
                ->where('status', 'selesai');

        if ($groupBy === 'daily') {
            $builder->groupBy('DATE(waktu_masuk)');
        } elseif ($groupBy === 'weekly') {
            $builder->select('WEEK(waktu_masuk) as minggu, YEAR(waktu_masuk) as tahun', false);
            $builder->groupBy('YEAR(waktu_masuk), WEEK(waktu_masuk)');
        } elseif ($groupBy === 'monthly') {
            $builder->select('MONTH(waktu_masuk) as bulan, YEAR(waktu_masuk) as tahun', false);
            $builder->groupBy('YEAR(waktu_masuk), MONTH(waktu_masuk)');
        }

        $builder->orderBy('tanggal', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Statistik dashboard
     */
    public function getDashboardStats()
    {
        $today = date('Y-m-d');
        $thisWeek = date('Y-m-d', strtotime('-7 days'));
        $thisMonth = date('Y-m-01');

        return [
            'aktif' => $this->where('status', 'aktif')->countAllResults(),
            'today' => $this->where('DATE(waktu_masuk)', $today)->countAllResults(),
            'today_revenue' => $this->selectSum('biaya')
                                   ->where('DATE(waktu_masuk)', $today)
                                   ->where('status', 'selesai')
                                   ->first()['biaya'] ?? 0,
            'week_revenue' => $this->selectSum('biaya')
                                  ->where('waktu_masuk >=', $thisWeek)
                                  ->where('status', 'selesai')
                                  ->first()['biaya'] ?? 0,
            'month_revenue' => $this->selectSum('biaya')
                                   ->where('waktu_masuk >=', $thisMonth)
                                   ->where('status', 'selesai')
                                   ->first()['biaya'] ?? 0,
        ];
    }

    /**
     * Ambil transaksi berdasarkan tanggal
     */
    public function getTransaksiByDate($tanggal)
    {
        return $this->where('DATE(waktu_masuk)', $tanggal)
                    ->where('status', 'selesai')
                    ->orderBy('waktu_masuk', 'ASC')
                    ->findAll();
    }
}