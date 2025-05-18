<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('evaluator_id');   // 評価する人（購入者 or 出品者）
            $table->unsignedBigInteger('evaluated_id');   // 評価される人
            $table->unsignedTinyInteger('score');         // 1〜5
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['item_id', 'evaluator_id']);  // 同じ人が同じ取引を2度評価できないよう制限
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
