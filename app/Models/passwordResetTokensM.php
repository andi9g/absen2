<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class passwordResetTokensM extends Model
{
  use HasFactory;
  protected $table = 'password_reset_tokens';
  protected $primaryKey = 'email';
  protected $connection = 'mysql';
  protected $guarded = [];
}
