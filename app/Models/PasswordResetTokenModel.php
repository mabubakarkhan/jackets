<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetTokenModel extends Model
{
    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'customer_id',
        'token',
        'code',
        'expires_at',
        'used',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'customer_id' => 'required|integer',
        'token' => 'required|max_length[255]',
        'code' => 'required|max_length[6]',
        'expires_at' => 'required|valid_date',
        'used' => 'permit_empty|integer'
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = [];
    protected $beforeUpdate = [];
    protected $afterInsert = [];
    protected $afterUpdate = [];

    /**
     * Create a new password reset token
     */
    public function createToken($customerId, $token, $code, $expiresAt)
    {
        // Invalidate any existing tokens for this customer
        $this->where('customer_id', $customerId)
             ->where('used', 0)
             ->set(['used' => 1])
             ->update();

        // Create new token
        return $this->insert([
            'customer_id' => $customerId,
            'token' => $token,
            'code' => $code,
            'expires_at' => $expiresAt,
            'used' => 0
        ]);
    }

    /**
     * Find valid token by code
     */
    public function findValidTokenByCode($code)
    {
        return $this->where('code', $code)
                   ->where('used', 0)
                   ->where('expires_at >', date('Y-m-d H:i:s'))
                   ->first();
    }

    /**
     * Find valid token by token string
     */
    public function findValidTokenByToken($token)
    {
        return $this->where('token', $token)
                   ->where('used', 0)
                   ->where('expires_at >', date('Y-m-d H:i:s'))
                   ->first();
    }

    /**
     * Mark token as used
     */
    public function markAsUsed($tokenId)
    {
        return $this->update($tokenId, ['used' => 1]);
    }

    /**
     * Clean expired tokens
     */
    public function cleanExpiredTokens()
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))
                   ->delete();
    }
}
