<?php
session_start();

// Data contoh, nanti diganti data dari database
$courts = [
  ['id' => 1, 'name' => 'Arena Garuda Futsal', 'sport_type' => 'Futsal',
   'facilities' => 'Toilet, kantin, parkir luas, ruang ganti', 'price_per_hour' => 150000, 'image' => 'court.jpg'],
  ['id' => 2, 'name' => 'GOR Smash Badminton', 'sport_type' => 'Badminton',
   'facilities' => 'AC, tribun, musala, parkir', 'price_per_hour' => 60000, 'image' => 'court.jpg'],
  ['id' => 3, 'name' => 'Hoops Court', 'sport_type' => 'Basket',
   'facilities' => 'Lapangan outdoor, lampu sorot, tribun', 'price_per_hour' => 100000, 'image' => 'court.jpg'],
];
$sportCounts = ['Futsal' => 4, 'Badminton' => 6, 'Basket' => 2];

require __DIR__ . '/../views/customer/home.php';