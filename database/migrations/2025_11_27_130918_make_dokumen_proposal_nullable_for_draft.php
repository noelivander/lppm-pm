<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Make columns nullable for draft support using raw SQL
        // This avoids Doctrine DBAL compatibility issues
        // First, clean up encrypted data that might exist in biaya_diusulkan
        
        // For penelitians table
        if (Schema::hasTable('penelitians')) {
            // Convert biaya_diusulkan to VARCHAR first to handle encrypted strings
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `biaya_diusulkan` VARCHAR(255) NULL');
            // Clean encrypted data (set to NULL if it looks like base64 encoded string)
            DB::statement("UPDATE `penelitians` SET `biaya_diusulkan` = NULL WHERE `biaya_diusulkan` REGEXP '^[A-Za-z0-9+/=]+$' AND LENGTH(`biaya_diusulkan`) > 20");
            // Convert back to DECIMAL
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `biaya_diusulkan` DECIMAL(15, 2) NULL');
            
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `judul` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `luaran_wajib` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `lama_penelitian` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `skema` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `ringkasan_proposal` TEXT NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `dokumen_proposal` VARCHAR(255) NULL');
        }
        
        // For penelitian table (if exists)
        if (Schema::hasTable('penelitian')) {
            // Convert biaya_diusulkan to VARCHAR first to handle encrypted strings
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `biaya_diusulkan` VARCHAR(255) NULL');
            // Clean encrypted data (set to NULL if it looks like base64 encoded string)
            DB::statement("UPDATE `penelitian` SET `biaya_diusulkan` = NULL WHERE `biaya_diusulkan` REGEXP '^[A-Za-z0-9+/=]+$' AND LENGTH(`biaya_diusulkan`) > 20");
            // Convert back to DECIMAL
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `biaya_diusulkan` DECIMAL(15, 2) NULL');
            
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `judul` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `luaran_wajib` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `lama_penelitian` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `skema` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `ringkasan_proposal` TEXT NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `dokumen_proposal` VARCHAR(255) NULL');
        }

        // For pengabdian table
        if (Schema::hasTable('pengabdian')) {
            // Convert biaya_diusulkan to VARCHAR first to handle encrypted strings
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `biaya_diusulkan` VARCHAR(255) NULL');
            // Clean encrypted data (set to NULL if it looks like base64 encoded string)
            DB::statement("UPDATE `pengabdian` SET `biaya_diusulkan` = NULL WHERE `biaya_diusulkan` REGEXP '^[A-Za-z0-9+/=]+$' AND LENGTH(`biaya_diusulkan`) > 20");
            // Convert back to DECIMAL
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `biaya_diusulkan` DECIMAL(15, 2) NULL');
            
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `judul` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `luaran_wajib` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `lama_penelitian` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `skema` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `ringkasan_proposal` TEXT NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `dokumen_proposal` VARCHAR(255) NULL');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert nullable changes (make required again)
        if (Schema::hasTable('penelitians')) {
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `judul` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `luaran_wajib` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `lama_penelitian` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `biaya_diusulkan` DECIMAL(15, 2) NOT NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `skema` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `ringkasan_proposal` TEXT NOT NULL');
            DB::statement('ALTER TABLE `penelitians` MODIFY COLUMN `dokumen_proposal` VARCHAR(255) NOT NULL');
        }
        
        if (Schema::hasTable('penelitian')) {
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `judul` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `luaran_wajib` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `lama_penelitian` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `biaya_diusulkan` DECIMAL(15, 2) NOT NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `skema` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `ringkasan_proposal` TEXT NOT NULL');
            DB::statement('ALTER TABLE `penelitian` MODIFY COLUMN `dokumen_proposal` VARCHAR(255) NOT NULL');
        }

        if (Schema::hasTable('pengabdian')) {
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `judul` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `luaran_wajib` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `lama_penelitian` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `biaya_diusulkan` DECIMAL(15, 2) NOT NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `skema` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `ringkasan_proposal` TEXT NOT NULL');
            DB::statement('ALTER TABLE `pengabdian` MODIFY COLUMN `dokumen_proposal` VARCHAR(255) NOT NULL');
        }
    }
};
