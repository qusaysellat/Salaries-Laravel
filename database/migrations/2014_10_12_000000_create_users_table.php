<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('role')->default(0);
            $table->string('address',2047)->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->integer('organization_id')->nullable();
            $table->integer('branch_id')->nullable();;
            $table->integer('position_id')->nullable();;
            $table->rememberToken();
            $table->timestamps();
        });

        $user=new User();
        $user->username='Admin';
        $user->password=bcrypt('00000000');
        $user->name='إدارة الموقع';
        $user->role=0;
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
