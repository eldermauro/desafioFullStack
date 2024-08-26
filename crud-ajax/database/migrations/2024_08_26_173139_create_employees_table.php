<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Ajuste conforme necessário
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2)->nullable();
            $table->date('data_validade')->nullable();
            $table->string('categoria')->nullable();
            $table->string('imagem')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('employees');
    }
}