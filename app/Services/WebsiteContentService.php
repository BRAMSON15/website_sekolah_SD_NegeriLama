<?php

namespace App\Services;

use App\Models\SchoolSetting;
use Illuminate\Support\Facades\Cache;

class WebsiteContentService
{
    private const CACHE_KEY = 'school_settings_data';

    /**
     * Retrieve all settings with caching to prevent repetitive DB queries.
     */
    public function getSettings(): array
    {
        return Cache::remember(self::CACHE_KEY, 86400, function () {
            return SchoolSetting::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Batch save settings and flush the cached copy.
     */
    public function saveSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            SchoolSetting::updateOrCreate(
                ['key' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }

        $this->clearCache();
    }

    /**
     * Retrieve school facilities list from settings or standard defaults.
     */
    public function getFacilitiesData(): array
    {
        $settings = $this->getSettings();
        $facilities = [];

        if (!empty($settings['facilities_data'])) {
            $facilities = is_array($settings['facilities_data'])
                ? $settings['facilities_data']
                : (json_decode($settings['facilities_data'], true) ?: []);
        }

        if (empty($facilities)) {
            $facilities = [
                ['title' => 'Laboratorium Komputer', 'icon' => 'fa-solid fa-desktop', 'desc' => 'Dilengkapi perangkat PC terbaru dan koneksi internet cepat untuk ANBK dan literasi digital.'],
                ['title' => 'Perpustakaan Digital', 'icon' => 'fa-solid fa-book-bookmark', 'desc' => 'Koleksi ribuan buku pelajaran, novel anak, dan e-book yang dapat diakses siswa kapan saja.'],
                ['title' => 'Laboratorium IPA', 'icon' => 'fa-solid fa-flask', 'desc' => 'Fasilitas praktek sains lengkap untuk melatih rasa ingin tahu dan eksperimen sains siswa.'],
                ['title' => 'Lapangan Olahraga', 'icon' => 'fa-solid fa-volleyball', 'desc' => 'Lapangan serbaguna untuk upacara, sepak bola, bola voli, basket, dan kegiatan senam bersama.'],
                ['title' => 'Musholla Sekolah', 'icon' => 'fa-solid fa-mosque', 'desc' => 'Tempat ibadah bersih dan nyaman untuk kegiatan sholat dzuhur berjamaah dan hafalan Al-Qur\'an.'],
                ['title' => 'Kantin Sehat', 'icon' => 'fa-solid fa-utensils', 'desc' => 'Menyediakan jajanan dan makanan bergizi yang terjamin kebersihan dan kesehatannya.'],
            ];
        }

        return $facilities;
    }

    /**
     * Update facilities list in school settings.
     */
    public function updateFacilities(array $facilities): void
    {
        $facilitiesData = array_values($facilities);
        $this->saveSettings([
            'facilities_data' => $facilitiesData,
        ]);
    }

    /**
     * Clear settings cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
