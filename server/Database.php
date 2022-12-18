<?php
error_reporting(1);

class Database{
    private $host ="192.168.56.136";
    private $dbname ="toko";
    private $user ="aziz";
    private $password ="1";
    private $port ="3306";
    private $conn;

      // function yang pertama kali di-load saat class dipanggil
    public function __construct()
    {
        // koneksi database
        try
        {
            $this->conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=utf8",$this->user,$this->password);
        }catch (PDOException $e)
        {  echo "Koneksi gagal";
        }
    }
    public function tampil_semua_data()
    {
        $query = $this->conn->prepare("select id_barang, nama_barang from barang order by id_barang");
        $query->execute();
        // mengambil banyak data dengan fetchAll
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        $query->closeCursor();
        unset($data);
    }
    
    public function tampil_data($id_barang)
    {
        $query = $this->conn->prepare("select id_barang,nama_barang from barang where id_barang=?");
        $query->execute(array($id_barang));
        // mengambil satu data dengan fetch
        $data = $query->fetch(PDO::FETCH_ASSOC);
        // mengembalikan data
        return $data;
        // hapus variable dari memory
        $query->closeCursor();
        unset($id_barang,$data);
    }

    public function tambah_data($data)
    {
        $query = $this->conn->prepare("insert ignore into barang (id_barang,nama_barang) values (?,?)");
        $query->execute(array($data['id_barang'],$data['nama_barang']));
        $query->closeCursor();
        unset($data);
    }

    public function ubah_data($data)
    {
        $query = $this->conn->prepare("update barang set nama_barang=? where id_barang=?");
        $query->execute(array($data['nama_barang'],$data['id_barang']));
        $query->closeCursor();
        unset($data);
    }

    public function hapus_data($id_barang)
    {
        $query = $this->conn->prepare("delete from barang where id_barang=?");
        $query->execute(array($id_barang));
        $query->closeCursor();
        unset($id_barang);
    }
}
?>