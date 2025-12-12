<?php
require_once __DIR__ . '/../config/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getStudentCount()
    {
        $sql = 'SELECT COUNT(*) as count FROM users WHERE role = 2';
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function getInstructorCount()
    {
        $sql = 'SELECT COUNT(*) as count FROM users WHERE role = 1';
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function findByEmailOrUsername($identifier)
    {
        $sql = 'SELECT * FROM users WHERE email = :id OR username = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $identifier]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = 'INSERT INTO users (username, email, password, fullname, role, bio, phone, specialization, experience, education, created_at) 
                VALUES (:username, :email, :password, :fullname, :role, :bio, :phone, :specialization, :experience, :education, NOW())';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':fullname' => $data['fullname'],
            ':role' => isset($data['role']) ? (int)$data['role'] : 0,
            ':bio' => $data['bio'] ?? '',
            ':phone' => $data['phone'] ?? '',
            ':specialization' => $data['specialization'] ?? '',
            ':experience' => $data['experience'] ?? '',
            ':education' => $data['education'] ?? ''
        ]);
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM users ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        return $this->findByEmail($email);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM users WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function update($id, $data)
    {
        $fields = [];
        $params = [':id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        
        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function updateAvatar($id, $avatarPath)
    {
        $sql = 'UPDATE users SET avatar = :avatar WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':avatar' => $avatarPath, ':id' => $id]);
    }
    
    public function getInstructors()
    {
        $sql = 'SELECT * FROM users WHERE role = 1 ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
