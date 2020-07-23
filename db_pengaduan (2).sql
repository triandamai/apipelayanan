-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jul 2020 pada 04.28
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pengaduan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
--

CREATE TABLE `chat` (
  `id_chat` varchar(36) NOT NULL,
  `id_sender` varchar(255) NOT NULL,
  `id_receiver` varchar(255) NOT NULL,
  `status` enum('ada','dihapus','diarchive') NOT NULL DEFAULT 'ada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_chat`
--

CREATE TABLE `detail_chat` (
  `id_detail_chat` varchar(255) NOT NULL,
  `id_chat` varchar(255) NOT NULL,
  `from_sender` varchar(255) NOT NULL,
  `to_receiver` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `media` text NOT NULL,
  `type` enum('text','image','textandimage') NOT NULL DEFAULT 'text',
  `status_detail` enum('ada','dihapus','diarchive') NOT NULL DEFAULT 'ada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` varchar(255) NOT NULL,
  `id_laporan` varchar(255) NOT NULL,
  `id_komentar_parent` varchar(255) NOT NULL,
  `body_komentar` text NOT NULL,
  `status` enum('ada','dihapus','archive') NOT NULL DEFAULT 'ada',
  `created_at` double NOT NULL DEFAULT current_timestamp(),
  `updated_at` double NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `id_laporan`, `id_komentar_parent`, `body_komentar`, `status`, `created_at`, `updated_at`) VALUES
('53454', '5f071e1dd69a3', 'sasfsfs', 'mohon bapak ibu sodara semua', 'ada', 20200709222344, 0),
('kosong', '5f071e1dd69a3', 'kosong', 'bzbs', 'ada', 20200709234233, 0),
('1594313403532', '5f071e1dd69a3', 'kosong', 'hai', 'ada', 20200709235003, 0),
('1594313411178', '5f071e1dd69a3', 'kosong', 'ini gimana?', 'ada', 20200709235011, 0),
('1594313479716', '5f071e1dd69a3', 'kosong', 'hehe', 'ada', 20200709235119, 0),
('1594313567331', '5f071e1dd69a3', 'kosong', 'maaf', 'ada', 20200709235247, 0),
('1594313650469', '5f071e1dd69a3', 'kosong', 'wkwk', 'ada', 20200709235410, 0),
('1594313658109', '5f071e1dd69a3', 'kosong', 'wkwk', 'ada', 20200709235418, 0),
('1594313667475', '5f071e1dd69a3', 'kosong', 'iya', 'ada', 20200709235427, 0),
('1594313676492', '5f071e1dd69a3', 'kosong', 'bB', 'ada', 20200709235436, 0),
('1594313679337', '5f071e1dd69a3', 'kosong', 'ahha', 'ada', 20200709235439, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `body` text NOT NULL,
  `media_laporan` text NOT NULL,
  `status_laporan` enum('ada','dihapus','archive') NOT NULL DEFAULT 'ada',
  `created_at` double NOT NULL DEFAULT current_timestamp(),
  `updated_at` double NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `level` enum('perangkat','kades','warga','') NOT NULL,
  `status_user` enum('ada','dihapus','archive') NOT NULL DEFAULT 'ada',
  `media_user` text NOT NULL,
  `created_at` double NOT NULL DEFAULT current_timestamp(),
  `updated_at` double NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `username`, `password`, `nik`, `level`, `status_user`, `media_user`, `created_at`, `updated_at`) VALUES
('123434546', 'Pak kades', 'jalan kedamaian', 'Jakarta', '0000-00-00', 'kadesdesa', '12345678', '232435', 'kades', '', 'https://www.jannineweigelofficial.com/wp-content/gallery/starboy/DSCF4501-2.jpg', 20200518090141, 20200517185517),
('234567534345', 'trian', 'dsfdgfhg', 'sdfdf', '2020-07-22', 'tr', '12345678', '23456', 'warga', '', 'https://www.jannineweigelofficial.com/wp-content/gallery/starboy/DSCF4501-2.jpg', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id_chat`);

--
-- Indeks untuk tabel `detail_chat`
--
ALTER TABLE `detail_chat`
  ADD PRIMARY KEY (`id_detail_chat`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
