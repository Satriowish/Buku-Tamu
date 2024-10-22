USE db_buku_tamu;

CREATE TABLE tb_admin (
  admin_id INT NOT NULL PRIMARY KEY IDENTITY(1,1),
  admin_name VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,
  admin_telp VARCHAR(20) NOT NULL,
  admin_email VARCHAR(50) NOT NULL,
  admin_address TEXT NOT NULL
);

INSERT INTO tb_admin (admin_name, username, password, admin_telp, admin_email, admin_address) VALUES
('Sampitak', 'admin', '21232f297a57a5a743894a0e4a801fc3', '08132655572', 'Sampitaksoper@admin.com', 'Jalan Gajah Mada, Kendal');


CREATE TABLE tb_kategori (
  kategori_id INT NOT NULL PRIMARY KEY IDENTITY(1,1),
  kategori_name VARCHAR(25) NOT NULL
);

INSERT INTO tb_kategori (kategori_name) VALUES
('VIP'),
('Biasa');

CREATE TABLE tb_tamu (
  tamu_id INT NOT NULL PRIMARY KEY IDENTITY(1,1),
  tamu_name VARCHAR(100) NOT NULL,
  keterangan VARCHAR(255) NOT NULL,
  tamu_telp VARCHAR(20) NOT NULL,
  tamu_email VARCHAR(50), 
  tamu_address TEXT, 
  kategori_id INT,
  waktu_kedatangan DATETIME DEFAULT GETDATE() NOT NULL, 
  admin_id INT, 
  CONSTRAINT FK_tb_tamu_admin FOREIGN KEY (admin_id) REFERENCES tb_admin (admin_id), -- Relasi ke admin
  CONSTRAINT FK_tb_tamu_kategori FOREIGN KEY (kategori_id) REFERENCES tb_kategori (kategori_id) -- Relasi ke kategori
);

-- isert data tamu
INSERT INTO tb_tamu (tamu_name, keterangan, tamu_telp, tamu_email, tamu_address, kategori_id, admin_id)
VALUES
('Dr Dree', 'Seminar', '08123456789', 'Dreee@example.com', 'Jl. Mawar No. 21', 1, 1), 
('Wiz Khalifa', 'Seminar', '08123456789', 'Khalifa@example.com', 'Jl. Kenanga No. 19', 1, 1),
('Ice Cube', 'Seminar', '08123456789', 'Icecube@example.com', 'Jl. Wijaya No. 18', 1, 1),
('Eazy E', 'Ambil Raport', '08123456789', 'Eazyeee@example.com', 'Jl. Melati No. 14', 2, 1),
('Ice T', 'Ambil Raport', '08123456789', 'Tripleee@example.com', 'Jl. Lavender No. 11', 2, 1),
('Wutang Gang', 'Ambil Raport', '08123456789', 'Wutanggang@example.com', 'Jl. Lotus No. 03', 2, 1),
('Kendrick Lamar', 'Seminar', '08123456789', 'Lmaooo@example.com', 'Jl. Bangka No. 10', 1, 1),
('The Game', 'Ambil Raport', '08123456789', 'Gameover@example.com', 'Jl. Kembang Kertas No. 05', 2, 1),
('Snoop Dog', 'Seminar', '08123456789', 'Madefaksnoop@example.com', 'Jl. Edelweis No. 15', 1, 1),
('Tupac', 'Ambil Raport', '08234567890', 'Tupac@example.com', 'Jl. Kamboja No. 25', 2, 1);
