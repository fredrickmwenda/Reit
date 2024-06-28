<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Concerns\HasSubscriptions;
use App\Repositories\SeoRepository;
use Carbon\Carbon;

class User extends Authenticatable
{
	use Notifiable, HasSubscriptions;
	protected $table = 'users';

	protected $primaryKey = 'id';

	protected $guarded = ['password_origin'];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token', 'password_origin'
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}

	public function RoleUser()
	{
		return $this->hasMany(RoleUser::class, 'user_id', 'id');
	}

	public function authorizeRoles($roles)
	{
		if (is_array($roles)) {
			return $this->hasAnyRole($roles) ||
				abort(401, 'This action is unauthorized.');
		}
		return $this->hasRole($roles) ||
			abort(401, 'This action is unauthorized.');
	}

	public function hasAnyRole($roles)
	{
		return null !== $this->roles()->whereIn('name', $roles)->first();
	}

	public function hasRole($role)
	{
		return null !== $this->roles()->where('name', $role)->first();
	}

	public function getUsers($data)
	{
		$default = [
			'role' => ''
		];

		$data = gmz_parse_args($data, $default);

		$query = $this->query();

		if (!empty($data['role'])) {
			$query->select(['users.*', 'role_user.role_id'])
				->where('role_id', $data['role'])
				->join('role_user', 'role_user.user_id', '=', "users.id", 'inner');
		}

		return $query->orderBy('users.id', 'ASC')->get();
	}


	//    public function createdServicesCount()
	//     {
	//         $serviceCounts = [
	//             'car' => $this->countService(Car::class),
	//             'property' => $this->countService(Sale::class),
	//             'hotel' => $this->countService(Hotel::class),
	//             'apartment' => $this->countService(Apartment::class),
	//             'space' => $this->countService(Space::class),
	//             'tour' => $this->countService(Tour::class),
	//             'beauty' => $this->countService(Beauty::class),
	//             // Add more services as needed
	//         ];

	//         return $serviceCounts;
	//     }

	//     private function countService($serviceModel)
	//     {
	//         // Assuming there is a relationship between User and each service model
	//         return $serviceModel::where('created_by', $this->id)->count();
	//     }

	// public function postsCount()
	// {
	// 	global $post;
	// 	$seoRepo = SeoRepository::inst();
	// 	dd($seoRepo);
	// 	$data = $seoRepo->where('author',get_current_user_id());
	// 	dd($data);
	// 	return Post::where('author', get_current_user_id())
	// 		->whereMonth('created_at', Carbon::now()->month)
	// 		->count();
	// }

	public function createdServicesCount()
    {
        $serviceCounts = [
            'car' => $this->countService(Car::class),
            'property' => $this->countService(Sale::class),
            'hotel' => $this->countService(Hotel::class),
            'apartment' => $this->countService(Apartment::class),
            'space' => $this->countService(Space::class),
            'tour' => $this->countService(Tour::class),
            'beauty' => $this->countService(Beauty::class),
            'posts' => $this->countService(Post::class),
            // Add more services as needed
        ];
	

        return $serviceCounts;
	
    }

    private function countService($serviceModel)
    {
        // Count the number of posts created by the user in the current month
	

        // For other service types, assume a direct relationship between User and each service model
        return $serviceModel::where('author', get_current_user_id())->count();
    }
}
