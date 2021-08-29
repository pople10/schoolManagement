<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\RolePrivilege;

class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    
    public $PRV = array(
        "MU" /*"Gestion des utilisateurs"*/,
        "MA"/*"Gestion des annonces"*/,
        "MF"/*"Gestion fillières"*/,
        "MTT"/*"Gestion d'emploi du temps"*/,
        "MI"/*"Gestion des stages"*/,
        "MRQ"/*"Gestion des demandes"*/,
        "ML"/*"Gestion du bibliothèque"*/,
        "MR"/*"Gestion des roles"*/,
        "MM"/*"Gestion des modules"*/,
        "MMN"/*"Gestion des notes"*/,
        "AP"/*"Affectation des professeurs"*/,
        "MC"/*"Gestion des cours"*/,
        "CS"/*"Consultation des statistiques"*/,
        "CM"/*"Consultation des notes"*/,
        "CC"/*"Consultation des cours"*/,
        "CRQ"/*"Consultation des demandes"*/,
        "CI"/*"Consultation des stages"*/,
        "CL"/*Consultation du bibliothèque*/,
        "CH"/*Consultation d'historique'*/,
        "ME"/*Gestion des examens*/,
        "CE"/*Consutation des examens*/,
        "UE"/*Utilisation des emails institutionnels*/
    );
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'vkey',
        'role_id',
        'matricule',
        'phd',
        'cne',
        'cin',
        'adress',
        'telephone',
        'verified',
        'sexe',
        'photo_path'
    ];
    
    
    /**
    *all attributes are mass assignable.
    * 
    * @var array
    *
    protected $guarded = [];

    **
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function prillege()
    {
        $userprv = RolePrivilege::all()->where("role_id","=",$this->role_id);
        $finalarray = array();
        foreach($userprv as $val)
            $finalarray[]=$this->PRV[(int)$val->privilege_id-1];
        return $finalarray;
    }
    
    public function getPrvAttribute()
    {
         return $this->prillege() ?? null;
    }
}
