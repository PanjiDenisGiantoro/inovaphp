-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2021 pada 07.16
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inovaklinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kota`
--

CREATE TABLE `kota` (
  `id` int(10) NOT NULL,
  `namakota` varchar(200) DEFAULT NULL,
  `id_provinsi` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kota`
--

INSERT INTO `kota` (`id`, `namakota`, `id_provinsi`) VALUES
(1, 'okok', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `kd_obat` char(5) NOT NULL,
  `nm_obat` varchar(100) NOT NULL,
  `harga_modal` int(10) NOT NULL,
  `harga_jual` int(10) NOT NULL,
  `stok` int(10) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`kd_obat`, `nm_obat`, `harga_modal`, `harga_jual`, `stok`, `keterangan`) VALUES
('T001', 'paracetamol', 30000, 40000, 89, 'okokok'),
('T002', 'vitacimin', 2000, 3000, 47, 'jijo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `nomor_rm` char(6) NOT NULL,
  `nm_pasien` varchar(100) NOT NULL,
  `no_identitas` varchar(40) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `gol_darah` enum('A','B','AB','O') NOT NULL,
  `agama` varchar(30) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `kota` varchar(200) DEFAULT NULL,
  `provinsi` varchar(200) DEFAULT NULL,
  `stts_nikah` enum('Menikah','Belum Nikah') NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `keluarga_status` enum('Ayah','Ibu','Suami','Istri','Saudara') NOT NULL,
  `keluarga_nama` varchar(100) NOT NULL,
  `keluarga_telepon` varchar(20) NOT NULL,
  `tgl_rekam` date NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`nomor_rm`, `nm_pasien`, `no_identitas`, `jns_kelamin`, `gol_darah`, `agama`, `tempat_lahir`, `tanggal_lahir`, `no_telepon`, `alamat`, `kota`, `provinsi`, `stts_nikah`, `pekerjaan`, `keluarga_status`, `keluarga_nama`, `keluarga_telepon`, `tgl_rekam`, `kd_petugas`) VALUES
('RM001', 'dimas', '3209819208310', 'Laki-laki', 'B', 'Islam', 'bandung', '2001-07-13', '0808097', 'bandung', '1', '5', 'Menikah', 'Karyawan', 'Ayah', 'sugiyo', '09898', '2021-07-13', 'P001'),
('RM002', 'des', '9988987', 'Laki-laki', 'AB', 'Islam', 'bandung', '2021-07-13', '089880', 'bandung', '1', '5', 'Menikah', 'Pegawai Negri Sipil(PNS)', 'Ayah', 'oso', 'ojo', '2021-07-13', 'P001'),
('RM003', 'panji', '0990898', 'Laki-laki', 'A', 'Islam', 'bandung', '2000-07-13', '08989088', 'bandung', '1', '5', 'Menikah', 'Karyawan', 'Ayah', 'kjlkjs', '098908', '2021-07-13', 'P001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `kd_pegawai` char(4) NOT NULL,
  `nm_pegawai` varchar(100) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `email` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`kd_pegawai`, `nm_pegawai`, `jns_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_telepon`, `email`) VALUES
('T006', 'dfaafd', 'Laki-laki', 'dafdf', '1961-07-12', 'sffds', '234243', '22223'),
('T007', 'debis', 'Laki-laki', 'bandung', '1994-07-13', 'bandung', '0998908908', 'anji@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `no_daftar` char(7) DEFAULT NULL,
  `nomor_rm` char(6) DEFAULT NULL,
  `tgl_daftar` date DEFAULT NULL,
  `tgl_janji` date DEFAULT NULL,
  `jam_janji` time DEFAULT NULL,
  `keluhan` varchar(100) DEFAULT NULL,
  `kd_tindakan` char(4) DEFAULT NULL,
  `nomor_antri` int(4) DEFAULT NULL,
  `kd_petugas` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`no_daftar`, `nomor_rm`, `tgl_daftar`, `tgl_janji`, `jam_janji`, `keluhan`, `kd_tindakan`, `nomor_antri`, `kd_petugas`) VALUES
('P001', 'RM003', '2021-07-13', '2021-07-13', '00:00:12', 'okoko', 'T001', 1, 'P001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `kd_petugas` char(4) NOT NULL,
  `nm_petugas` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'Kasir'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`kd_petugas`, `nm_petugas`, `no_telepon`, `username`, `password`, `level`) VALUES
('P001', 'Bunafit Nugroho', '081192345111', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin'),
('P002', 'Fitria Prasetya', '081192244563', 'klinik', '21232f297a57a5a743894a0e4a801fc3', 'Klinik'),
('P003', 'Septi Suhesti', '081193342223', 'apotek', '21232f297a57a5a743894a0e4a801fc3', 'Apotek'),
('P004', 'denis', '096733277', 'denis', 'c3875d07f44c422f3b3bc019c23e16ae', 'Apotek'),
('P005', 'gian', '0890808', 'gian', '56ea9c664e8c9f1ad611cf8e5f1bb41c', 'Klinik');

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinsi`
--

CREATE TABLE `provinsi` (
  `id` int(10) NOT NULL,
  `namaprovinsi` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `provinsi`
--

INSERT INTO `provinsi` (`id`, `namaprovinsi`) VALUES
(1, 'okokok'),
(2, 'ok'),
(4, 'llkl'),
(5, 'ajsdj');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rawat`
--

CREATE TABLE `rawat` (
  `no_rawat` char(7) NOT NULL,
  `tgl_rawat` date NOT NULL,
  `nomor_rm` char(6) NOT NULL,
  `nm_pasien` varchar(45) NOT NULL,
  `hasil_diagnosa` varchar(100) NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rawat`
--

INSERT INTO `rawat` (`no_rawat`, `tgl_rawat`, `nomor_rm`, `nm_pasien`, `hasil_diagnosa`, `uang_bayar`, `kd_petugas`) VALUES
('R002', '2021-07-13', 'RM003', 'panji', 'okok', 30000, 'P001'),
('R001', '0000-00-00', 'RM003', 'panji', 'okok', 30000, 'P001'),
('R003', '2021-07-13', 'RM003', 'panji', 'okok', 30000, 'P001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rawat_tindakan`
--

CREATE TABLE `rawat_tindakan` (
  `id_tindakan` int(7) NOT NULL,
  `tgl_tindakan` date NOT NULL,
  `no_rawat` char(7) NOT NULL,
  `kd_tindakan` char(4) NOT NULL,
  `harga` int(10) NOT NULL,
  `kd_pegawai` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rawat_tindakan`
--

INSERT INTO `rawat_tindakan` (`id_tindakan`, `tgl_tindakan`, `no_rawat`, `kd_tindakan`, `harga`, `kd_pegawai`) VALUES
(6, '2021-07-13', 'R003', 'T002', 30000, 'T007'),
(5, '2021-07-13', 'R002', 'T001', 30000, 'T006'),
(4, '0000-00-00', 'R001', 'T001', 30000, 'T007');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resep`
--

CREATE TABLE `resep` (
  `no_penjualan` char(7) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `nomor_rm` varchar(6) NOT NULL,
  `pelanggan` varchar(100) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `uang_bayar` int(12) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `resep`
--

INSERT INTO `resep` (`no_penjualan`, `tgl_penjualan`, `nomor_rm`, `pelanggan`, `keterangan`, `uang_bayar`, `kd_petugas`) VALUES
('PR001', '2021-07-12', 'R001', 'Sardi Sudrajad', 'okok', 100000, 'P001'),
('PR002', '2021-07-13', 'R002', 'panji', 'okok', 43000, 'P001'),
('PR003', '2021-07-13', 'R003', 'panji', 'okoko', 6000, 'P001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resep_item`
--

CREATE TABLE `resep_item` (
  `no_penjualan` char(7) NOT NULL,
  `kd_obat` char(5) NOT NULL,
  `harga_modal` int(12) NOT NULL,
  `harga_jual` int(12) NOT NULL,
  `jumlah` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `resep_item`
--

INSERT INTO `resep_item` (`no_penjualan`, `kd_obat`, `harga_modal`, `harga_jual`, `jumlah`) VALUES
('PR003', 'T002', 2000, 3000, 1),
('PR002', 'T001', 30000, 40000, 1),
('PR002', 'T002', 2000, 3000, 1),
('PR003', 'T002', 2000, 3000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan`
--

CREATE TABLE `tindakan` (
  `kd_tindakan` char(4) NOT NULL,
  `nm_tindakan` varchar(100) NOT NULL,
  `harga` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tindakan`
--

INSERT INTO `tindakan` (`kd_tindakan`, `nm_tindakan`, `harga`) VALUES
('T000', 'jkjl', 9000),
('T001', 'perut sakit', 30000),
('T002', 'gatal aduh', 30000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_penjualan`
--

CREATE TABLE `tmp_penjualan` (
  `id` int(10) NOT NULL,
  `kd_obat` char(5) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_rawat`
--

CREATE TABLE `tmp_rawat` (
  `id` int(10) NOT NULL,
  `kd_tindakan` char(4) DEFAULT NULL,
  `harga` int(12) DEFAULT NULL,
  `kd_pegawai` char(4) DEFAULT NULL,
  `kd_petugas` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_resep`
--

CREATE TABLE `tmp_resep` (
  `id` int(10) NOT NULL,
  `kd_obat` char(5) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `kd_petugas` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`kd_obat`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`nomor_rm`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`kd_pegawai`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`kd_petugas`);

--
-- Indeks untuk tabel `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rawat`
--
ALTER TABLE `rawat`
  ADD PRIMARY KEY (`no_rawat`);

--
-- Indeks untuk tabel `rawat_tindakan`
--
ALTER TABLE `rawat_tindakan`
  ADD PRIMARY KEY (`id_tindakan`);

--
-- Indeks untuk tabel `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`no_penjualan`);

--
-- Indeks untuk tabel `resep_item`
--
ALTER TABLE `resep_item`
  ADD KEY `nomor_penjualan_tamu` (`no_penjualan`,`kd_obat`);

--
-- Indeks untuk tabel `tindakan`
--
ALTER TABLE `tindakan`
  ADD PRIMARY KEY (`kd_tindakan`);

--
-- Indeks untuk tabel `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tmp_rawat`
--
ALTER TABLE `tmp_rawat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tmp_resep`
--
ALTER TABLE `tmp_resep`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kota`
--
ALTER TABLE `kota`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `rawat_tindakan`
--
ALTER TABLE `rawat_tindakan`
  MODIFY `id_tindakan` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tmp_resep`
--
ALTER TABLE `tmp_resep`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
