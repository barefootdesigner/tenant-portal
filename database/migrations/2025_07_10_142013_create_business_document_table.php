<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessDocumentTable extends Migration
{
    public function up()
    {
        Schema::create('business_document', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['business_id', 'document_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_document');
    }
}
