<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        $demoPassword = Hash::make('password');

        $sellers = collect([
            ['name' => 'Marta Kowalska', 'email' => 'marta@example.test'],
            ['name' => 'Jan Nowak', 'email' => 'jan@example.test'],
            ['name' => 'Ola Zielińska', 'email' => 'ola@example.test'],
            ['name' => 'Tomek Wiśniewski', 'email' => 'tomek@example.test'],
        ])->mapWithKeys(function (array $seller) use ($demoPassword) {
            return [
                $seller['email'] => User::firstOrCreate(
                    ['email' => $seller['email']],
                    [
                        'name' => $seller['name'],
                        'password' => $demoPassword,
                        'role' => 'general',
                        'email_verified_at' => now(),
                    ],
                ),
            ];
        });

        $examples = [
            [
                'title' => 'Fotel z lat 60. po renowacji',
                'description' => 'Dębowy stelaż, nowa tapicerka w kolorze oliwkowym. Wygodny i gotowy na kolejne lata.',
                'tags' => 'dom,vintage,meble',
                'image' => 'demo/listing/demo-chair.svg',
                'seller' => 'marta@example.test',
            ],
            [
                'title' => 'Rower miejski Romet — rozmiar M',
                'description' => 'Lekki, sprawny rower na codzienne przejazdy. Po przeglądzie, z nowym siodełkiem.',
                'tags' => 'rowery,sport,miasto',
                'image' => 'demo/listing/demo-bicycle.svg',
                'seller' => 'jan@example.test',
            ],
            [
                'title' => 'Lampa stołowa z mlecznym kloszem',
                'description' => 'Prosta lampa z mosiężną podstawą. Daje ciepłe, miękkie światło do czytania.',
                'tags' => 'dom,wnętrza,vintage',
                'image' => 'demo/listing/demo-lamp.svg',
                'seller' => 'ola@example.test',
            ],
            [
                'title' => 'Aparat analogowy Olympus Trip',
                'description' => 'Klasyczny kompakt z obiektywem 40 mm. Migawka działa, światłomierz sprawdzony.',
                'tags' => 'technologia,fotografia,vintage',
                'image' => 'demo/listing/demo-camera.svg',
                'seller' => 'tomek@example.test',
            ],
            [
                'title' => 'Ceramiczny wazon z pracowni',
                'description' => 'Ręcznie szkliwiony wazon w głębokim kobaltowym kolorze. Każda sztuka jest trochę inna.',
                'tags' => 'dom,wnętrza,ceramika',
                'image' => 'demo/listing/demo-vase.svg',
                'seller' => 'ola@example.test',
            ],
            [
                'title' => 'Płyty winylowe — jazz i soul',
                'description' => 'Zestaw pięciu albumów w dobrym stanie. Chętnie oddam komuś, kto będzie ich słuchać.',
                'tags' => 'ksiazki,muzyka,kolekcje',
                'image' => 'demo/listing/demo-vinyl.svg',
                'seller' => 'marta@example.test',
            ],
            [
                'title' => 'Skórzana torba na ramię',
                'description' => 'Naturalna skóra, regulowany pasek i kieszeń na telefon. Z czasem nabrała pięknej patyny.',
                'tags' => 'moda,akcesoria,skóra',
                'image' => 'demo/listing/demo-bag.svg',
                'seller' => 'jan@example.test',
            ],
            [
                'title' => 'Stolik kawowy z litego drewna',
                'description' => 'Niewielki stolik wykonany ręcznie z jesionu. Naturalne wykończenie olejem.',
                'tags' => 'dom,vintage,meble',
                'image' => 'demo/listing/demo-table.svg',
                'seller' => 'tomek@example.test',
            ],
            [
                'title' => 'Zestaw książek o polskim designie',
                'description' => 'Trzy albumy o wzornictwie i architekturze. Stan bardzo dobry, bez notatek.',
                'tags' => 'ksiazki,design,dom',
                'image' => 'demo/listing/demo-books.svg',
                'seller' => 'ola@example.test',
            ],
            [
                'title' => 'Kask rowerowy Thousand — rozmiar L',
                'description' => 'Matowy granat, wygodne zapięcie magnetyczne. Używany kilka razy, bez uszkodzeń.',
                'tags' => 'rowery,sport,akcesoria',
                'image' => 'demo/listing/demo-helmet.svg',
                'seller' => 'jan@example.test',
            ],
            [
                'title' => 'Klawiatura mechaniczna Keychron K2',
                'description' => 'Kompaktowa klawiatura z przełącznikami brown. Działa przewodowo i przez Bluetooth.',
                'tags' => 'technologia,komputer,biuro',
                'image' => 'demo/listing/demo-keyboard.svg',
                'seller' => 'tomek@example.test',
            ],
            [
                'title' => 'Lniana koszula w kolorze ecru',
                'description' => 'Przewiewna koszula z grubej europejskiej lnianki. Rozmiar M, fason lekko oversize.',
                'tags' => 'moda,ubrania,len',
                'image' => 'demo/listing/demo-shirt.svg',
                'seller' => 'marta@example.test',
            ],
        ];

        foreach ($examples as $example) {
            $seller = $sellers[$example['seller']];
            unset($example['seller']);

            Listing::updateOrCreate(
                ['title' => $example['title']],
                [
                    ...$example,
                    'user_id' => $seller->id,
                    'email' => $seller->email,
                    'link' => null,
                    'approved' => true,
                ],
            );
        }
    }
}
