<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Add slug to bundles
        Schema::table('bundles', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
        });

        // Backfill bundles
        DB::table('bundles')->get()->each(function ($bundle) {
            $base = Str::slug($bundle->name);
            $slug = $base;
            $i = 1;
            while (DB::table('bundles')->where('slug', $slug)->where('id', '!=', $bundle->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            DB::table('bundles')->where('id', $bundle->id)->update(['slug' => $slug]);
        });

        // Add unique index after backfill
        Schema::table('bundles', function (Blueprint $table) {
            $table->unique('slug');
        });

        // Backfill brands (slug column exists but may be empty)
        DB::table('brands')->where(function ($q) {
            $q->whereNull('slug')->orWhere('slug', '');
        })->get()->each(function ($brand) {
            $base = Str::slug($brand->name);
            $slug = $base;
            $i = 1;
            while (DB::table('brands')->where('slug', $slug)->where('id', '!=', $brand->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            DB::table('brands')->where('id', $brand->id)->update(['slug' => $slug]);
        });

        // Backfill categories (slug column exists but may be empty)
        DB::table('categories')->where(function ($q) {
            $q->whereNull('slug')->orWhere('slug', '');
        })->get()->each(function ($category) {
            $base = Str::slug($category->name);
            $slug = $base;
            $i = 1;
            while (DB::table('categories')->where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            DB::table('categories')->where('id', $category->id)->update(['slug' => $slug]);
        });
    }

    public function down(): void
    {
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
