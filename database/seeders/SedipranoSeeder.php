<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Genero;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SedipranoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //DB::table('sedipranos')->truncate();

        $sedipranosData = [
            [
                'codigo' => '1050100720',
                'dni' => '73113432',
                'primer_apellido' => 'Requejo',
                'segundo_apellido' => 'Valle',
                'carrera_id' => 1,  // Administración
                'celular' => '932644100',
                'fecha_nacimiento' => Carbon::parse('2002-06-10'),
                'user_id' => $this->createUser('Aitana Sofía', 'T050100720@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'qr_code' => NULL,
                'qr_path' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'codigo' => '1050601920',
                'dni' => '72712935',
                'primer_apellido' => 'Pretell',
                'segundo_apellido' => 'Canchas',
                'carrera_id' => 11, // Derecho
                'celular' => '993879048',
                'fecha_nacimiento' => Carbon::parse('2001-04-19'),
                'user_id' => $this->createUser('Alisson Milagros', 'pretellalisson@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010100624',
                'dni' => '71507469',
                'primer_apellido' => 'Segura',
                'segundo_apellido' => 'Aredo',
                'carrera_id' => 1,  // Administración
                'celular' => '938936537',
                'fecha_nacimiento' => Carbon::parse('2005-09-24'),
                'user_id' => $this->createUser('Ana Nicoll', 'anseguraa@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1020101420',
                'dni' => '77813603',
                'primer_apellido' => 'Ruiz',
                'segundo_apellido' => 'Rodriguez',
                'carrera_id' => 1,  // Administración
                'celular' => '994267405',
                'fecha_nacimiento' => Carbon::parse('2001-10-25'),
                'user_id' => $this->createUser('Bricelly Jazmin', 'bricelly2001@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051302521',
                'dni' => '70992230',
                'primer_apellido' => 'Chavez',
                'segundo_apellido' => 'Padilla',
                'carrera_id' => 34,  // Ingenieria Industrial
                'celular' => '941972261',
                'fecha_nacimiento' => Carbon::parse('2003-10-24'),
                'user_id' => $this->createUser('Dulce Geraldine', 't1051302521@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1024000121',
                'dni' => '71293533',
                'primer_apellido' => 'Pichén',
                'segundo_apellido' => 'Zavaleta',
                'carrera_id' => 30,  // Ingenieria Civil
                'celular' => '939749079',
                'fecha_nacimiento' => Carbon::parse('2004-01-25'),
                'user_id' => $this->createUser('Elber Isaí', 'pichenzavaleta@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'codigo' => '1054000920',
            //     'dni' => '70986876',
            //     'primer_apellido' => 'Sanchez',
            //     'segundo_apellido' => 'Palacios',
            //     'carrera_id' => 30,  // Ingenieria Civil
            //     'celular' => '964916454',
            //     'fecha_nacimiento' => Carbon::parse('2001-06-08'),
            //     'user_id' => $this->createUser('Fernando', 't054000920@unitru.edu.pe', null),
            //     'cargo_id' => 3,
            //     'area_id' => 5,
            //     'genero' => Genero::Masculino->value, // Usa el Enum para el género
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            [
                'codigo' => '1051500121',
                'dni' => '73479500',
                'primer_apellido' => 'Alfaro',
                'segundo_apellido' => 'Tandaypan',
                'carrera_id' => 37,  // Ingenieria Metalurgica
                'celular' => '955250292',
                'fecha_nacimiento' => Carbon::parse('2004-05-20'),
                'user_id' => $this->createUser('Gerson Gabriel', 'gersonalfa20@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1524000424',
                'dni' => '61758330',
                'primer_apellido' => 'Avila',
                'segundo_apellido' => 'Santillan',
                'carrera_id' => 30,  // Ingenieria Civil
                'celular' => '939255862',
                'fecha_nacimiento' => Carbon::parse('2005-08-11'),
                'user_id' => $this->createUser('José Daniel', 'Josedanielsantiavila@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1041500221',
                'dni' => '70608670',
                'primer_apellido' => 'Hernández',
                'segundo_apellido' => 'Jáuregui', 
                'carrera_id' => 37,  // Ing Metalurgica
                'celular' => '993658887',
                'fecha_nacimiento' => Carbon::parse('2003-10-04'),
                'user_id' => $this->createUser('Juan Diego', 'juanhjauregui15@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1020100424',
                'dni' => '60778246',
                'primer_apellido' => 'Chávez',
                'segundo_apellido' => 'Rosales',
                'carrera_id' => 1,  // Administración
                'celular' => '920252019',
                'fecha_nacimiento' => Carbon::parse('2006-05-09'),
                'user_id' => $this->createUser('Lisseth Adelaida', 'Chavezadelaida25@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510601623',
                'dni' => '75394299',
                'primer_apellido' => 'Angulo',
                'segundo_apellido' => 'Urbina',
                'carrera_id' => 11, // Derecho
                'celular' => '941933871',
                'fecha_nacimiento' => Carbon::parse('2005-07-24'),
                'user_id' => $this->createUser('Luz Karina', 'lkangulour@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1050102021',
                'dni' => '72282922',
                'primer_apellido' => 'Fernández',
                'segundo_apellido' => 'Leyva',
                'carrera_id' => 1,  // Administración
                'celular' => '904730836',
                'fecha_nacimiento' => Carbon::parse('2004-07-10'),
                'user_id' => $this->createUser('Mariann Estefany', 'maryferley.2004@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510600121',
                'dni' => '72673121',
                'primer_apellido' => 'Gonzales',
                'segundo_apellido' => 'Torres',
                'carrera_id' => 11, // Derecho
                'celular' => '942221638',
                'fecha_nacimiento' => Carbon::parse('2002-09-17'),
                'user_id' => $this->createUser('Marina Lizeth', 't1510600121@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051300421',
                'dni' => '70256048',
                'primer_apellido' => 'García',
                'segundo_apellido' => 'García',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '947275397',
                'fecha_nacimiento' => Carbon::parse('2002-08-12'),
                'user_id' => $this->createUser('Michael Junior', 't1051300421@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1523700122',
                'dni' => '71340979',
                'primer_apellido' => 'Alama',
                'segundo_apellido' => 'Terrones',
                'carrera_id' => 30, // Ing Ambiental
                'celular' => '973317923',
                'fecha_nacimiento' => Carbon::parse('2004-07-30'),
                'user_id' => $this->createUser('Nashaly Nicolle', 'nashalyalamaterrones@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1514000824',
                'dni' => '72885589',
                'primer_apellido' => 'Carrasco',
                'segundo_apellido' => 'Lalangui', 
                'carrera_id' => 30, // Ing Civil
                'celular' => '949804469',
                'fecha_nacimiento' => Carbon::parse('2006-03-02'),
                'user_id' => $this->createUser('Renzo Georkael', 'rgcarrascol@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'codigo' => '1514100724',
            //     'dni' => '71101729',
            //     'primer_apellido' => 'Gamboa',
            //     'segundo_apellido' => 'Gonzáles',
            //     'carrera_id' => 5,  // Arq
            //     'celular' => '976296032',
            //     'fecha_nacimiento' => Carbon::parse('2005-12-08'),
            //     'user_id' => $this->createUser('Rodrigo Marcial', 'rodrigogg0812@gmail.com', null),
            //     'cargo_id' => 3,
            //     'area_id' => 5,
            //      'genero' => Genero::Masculino->value, // Usa el Enum para el género
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            [
                'codigo' => '1510100922',
                'dni' => '75340255',
                'primer_apellido' => 'Juarez',
                'segundo_apellido' => 'Cruz',
                'carrera_id' => 1, // Admin
                'celular' => '939780649',
                'fecha_nacimiento' => Carbon::parse('1999-08-01'),
                'user_id' => $this->createUser('Santos Maria', 'sjuarez@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010101122',
                'dni' => '70618936',
                'primer_apellido' => 'Pereda',
                'segundo_apellido' => 'Llave',
                'carrera_id' => 1, // Admin
                'celular' => '947397363',
                'fecha_nacimiento' => Carbon::parse('2001-12-19'),
                'user_id' => $this->createUser('Valeria', 'speredal@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                 'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1454000222',
                'dni' => '73811722',
                'primer_apellido' => 'Carruitero',
                'segundo_apellido' => 'Aspiros',
                'carrera_id' => 30, // Ing Civil
                'celular' => '989529234',
                'fecha_nacimiento' => Carbon::parse('2005-01-03'),
                'user_id' => $this->createUser('Yrma Lucero', 'ycarruitero@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1020100521',
                'dni' => '74347919',
                'primer_apellido' => 'Cuadra',
                'segundo_apellido' => 'Rodriguez',
                'carrera_id' => 1, // Admin
                'celular' => '927256178',
                'fecha_nacimiento' => Carbon::parse('2002-03-18'),
                'user_id' => $this->createUser('Yuliana Zarai', 'Zaraicuadra18@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                 'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051301320',
                'dni' => '71089194',
                'primer_apellido' => 'Castro',
                'segundo_apellido' => 'Torres',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '949571234',
                'fecha_nacimiento' => Carbon::parse('2000-08-28'),
                'user_id' => $this->createUser('Candy Yoana', 'yoanacast1728@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                 'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051302523',
                'dni' => '76753292',
                'primer_apellido' => 'Valverde',
                'segundo_apellido' => 'Caspito',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '949263553',
                'fecha_nacimiento' => Carbon::parse('2005-07-04'),
                'user_id' => $this->createUser('Christian Rodrigo', 'christiancvalverdecaspito@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1020100520',
                'dni' => '70668762',
                'primer_apellido' => 'Rivera',
                'segundo_apellido' => 'Medina',
                'carrera_id' => 1, // Admin
                'celular' => '965828966',
                'fecha_nacimiento' => Carbon::parse('2003-03-04'),
                'user_id' => $this->createUser('Dajhana Del Rocío', 'Dajhanariverame4@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010100421',
                'dni' => '74028478',
                'primer_apellido' => 'Rodriguez',
                'segundo_apellido' => 'Sabana',
                'carrera_id' => 1, // Admin
                'celular' => '967130492',
                'fecha_nacimiento' => Carbon::parse('2003-01-16'),
                'user_id' => $this->createUser('Diego Jesus', 'diego.rodriguez160103@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1511300222',
                'dni' => '71080474',
                'primer_apellido' => 'Jiménez',
                'segundo_apellido' => 'Vílchez',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '977661136',
                'fecha_nacimiento' => Carbon::parse('2004-04-15'),
                'user_id' => $this->createUser('Eddie Alessandro', 'eajimenezv04@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051300123',
                'dni' => '76393353',
                'primer_apellido' => 'Paredes',
                'segundo_apellido' => 'Calderón',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '975268502',
                'fecha_nacimiento' => Carbon::parse('2005-10-02'),
                'user_id' => $this->createUser('Fabián Nicolas', 'fnparedesca@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510101721',
                'dni' => '70398008',
                'primer_apellido' => 'Rojas',
                'segundo_apellido' => 'Rodriguez',
                'carrera_id' => 1, // Admin
                'celular' => '962076714',
                'fecha_nacimiento' => Carbon::parse('2003-03-31'),
                'user_id' => $this->createUser('Fernanda Milagros', 't1510101721@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                 'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010700523',
                'dni' => '72503219',
                'primer_apellido' => 'Paredes',
                'segundo_apellido' => 'Cachique',
                'carrera_id' => 12, // Economia
                'celular' => '925844775',
                'fecha_nacimiento' => Carbon::parse('2004-09-22'),
                'user_id' => $this->createUser('Grecia Alexandra', 'Gaparedesca@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1050101020',
                'dni' => '77078926',
                'primer_apellido' => 'Graus',
                'segundo_apellido' => 'Silva',
                'carrera_id' => 1, // Admin
                'celular' => '900253657',
                'fecha_nacimiento' => Carbon::parse('2002-04-13'),
                'user_id' => $this->createUser('Handalee Georjina', 'handaleegraussilva@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1513701420',
                'dni' => '77144041',
                'primer_apellido' => 'Leon',
                'segundo_apellido' => 'Mallqui',
                'carrera_id' => 30, // Ing Ambiental
                'celular' => '945201733',
                'fecha_nacimiento' => Carbon::parse('2001-02-13'),
                'user_id' => $this->createUser('Jean Cristopher Elias', 'jeanleon1302@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1511601421',
                'dni' => '71243325',
                'primer_apellido' => 'Vigo',
                'segundo_apellido' => 'Cepeda',
                'carrera_id' => 38, // Ing Quimica
                'celular' => '973365000',
                'fecha_nacimiento' => Carbon::parse('2024-03-15'),
                'user_id' => $this->createUser('Jhosmel Anderson', 'jhosmelvigoc4@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010100122',
                'dni' => '71116743',
                'primer_apellido' => 'Cáceda',
                'segundo_apellido' => 'Olivera',
                'carrera_id' => 1, // Admin
                'celular' => '900863015',
                'fecha_nacimiento' => Carbon::parse('2001-04-24'),
                'user_id' => $this->createUser('Jimmy Andersonn', 'jcacedao@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1050101421',
                'dni' => '74293965',
                'primer_apellido' => 'Tisnado',
                'segundo_apellido' => 'Sauceda',
                'carrera_id' => 1, // Admin
                'celular' => '967371655',
                'fecha_nacimiento' => Carbon::parse('2002-10-05'),
                'user_id' => $this->createUser('Jimmy Javier', 'jimmytisnado1419@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510101021',
                'dni' => '74908357',
                'primer_apellido' => 'Rodríguez',
                'segundo_apellido' => 'Alfaro',
                'carrera_id' => 1, // Admin
                'celular' => '981757872',
                'fecha_nacimiento' => Carbon::parse('2003-02-23'),
                'user_id' => $this->createUser('Kevin Gamaliel', 'T1510101021@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1511300521',
                'dni' => '76335297',
                'primer_apellido' => 'Laureano',
                'segundo_apellido' => 'Escobedo',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '955904422',
                'fecha_nacimiento' => Carbon::parse('2001-10-06'),
                'user_id' => $this->createUser('Luis Angel', 't1511300521@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010700721',
                'dni' => '73257054',
                'primer_apellido' => 'Pretell',
                'segundo_apellido' => 'Leon',
                'carrera_id' => 12, // Economia
                'celular' => '924643420',
                'fecha_nacimiento' => Carbon::parse('2002-08-18'),
                'user_id' => $this->createUser('María Fernanda', 'maferp1827@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510701323',
                'dni' => '70498842',
                'primer_apellido' => 'Gil',
                'segundo_apellido' => 'Zapata',
                'carrera_id' => 12, // Economia
                'celular' => '70498842',
                'fecha_nacimiento' => Carbon::parse('2005-05-05'),
                'user_id' => $this->createUser('Mixie Arleni', 'magilza@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1011300523',
                'dni' => '72769554',
                'primer_apellido' => 'Plasencia',
                'segundo_apellido' => 'de la Cruz',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '949929229',
                'fecha_nacimiento' => Carbon::parse('2006-01-31'),
                'user_id' => $this->createUser('Nestor Rafael', 'nrplasenciade@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1512400421',
                'dni' => '72919451',
                'primer_apellido' => 'Facundo',
                'segundo_apellido' => 'Reyes',
                'carrera_id' => 29, // Ing Agroindustrial
                'celular' => '981028963',
                'fecha_nacimiento' => Carbon::parse('2002-10-18'),
                'user_id' => $this->createUser('Sebastian Emanuel', 't1512400421@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1451200122',
                'dni' => '70941690',
                'primer_apellido' => 'Aliaga',
                'segundo_apellido' => 'Pretell', 
                'carrera_id' => 25, // Fisica
                'celular' => '928810787',
                'fecha_nacimiento' => Carbon::parse('2004-09-22'),
                'user_id' => $this->createUser('Tatiana Yuleisy', 'taliaga@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 2,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510100321',
                'dni' => '72910786',
                'primer_apellido' => 'Valverde',
                'segundo_apellido' => 'Zavaleta',
                'carrera_id' => 1, // Admin
                'celular' => '939856433',
                'fecha_nacimiento' => Carbon::parse('2002-01-25'),
                'user_id' => $this->createUser('Adeli', 'Adelivalverdezavaleta@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1020101321',
                'dni' => '70582834',
                'primer_apellido' => 'Rojas',
                'segundo_apellido' => 'Chávez',
                'carrera_id' => 1, // Admin
                'celular' => '998886773',
                'fecha_nacimiento' => Carbon::parse('2003-09-06'),
                'user_id' => $this->createUser('Ana Lucía', 'anarojcha@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1511601122',
                'dni' => '70725008',
                'primer_apellido' => 'Otiniano',
                'segundo_apellido' => 'Morales',
                'carrera_id' => 38, // Ing Quimica
                'celular' => '950023796',
                'fecha_nacimiento' => Carbon::parse('2001-11-09'),
                'user_id' => $this->createUser('Anderson Abat', 'aotinianom@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1024000721',
                'dni' => '71046882',
                'primer_apellido' => 'Iparraguirre',
                'segundo_apellido' => 'Aguilar',
                'carrera_id' => 30, // Ing Civil
                'celular' => '924097546',
                'fecha_nacimiento' => Carbon::parse('2004-07-23'),
                'user_id' => $this->createUser('Angel', 't1024000721@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1013600421',
                'dni' => '74175282',
                'primer_apellido' => 'Recuenco',
                'segundo_apellido' => 'Tapia',
                'carrera_id' => 36, // Ing Mecatronica
                'celular' => '948316642',
                'fecha_nacimiento' => Carbon::parse('2001-10-04'),
                'user_id' => $this->createUser('Angie Tatiana', 't1013600421@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                 'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1053703122',
                'dni' => '74232737',
                'primer_apellido' => 'Arroyo',
                'segundo_apellido' => 'Esquivel',
                'carrera_id' => 30, // Ing Ambiental
                'celular' => '973868299',
                'fecha_nacimiento' => Carbon::parse('2004-07-11'),
                'user_id' => $this->createUser('Belinda Maricielo', 'bm.arroyoesquivel@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1050700220',
                'dni' => '71336621',
                'primer_apellido' => 'Ulloa',
                'segundo_apellido' => 'Torres',
                'carrera_id' => 12, // Economia
                'celular' => '964747873',
                'fecha_nacimiento' => Carbon::parse('2003-04-02'),
                'user_id' => $this->createUser('Cesar Arturo', 'arturoulloat@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 3,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1050100124',
                'dni' => '60879707',
                'primer_apellido' => 'Abanto',
                'segundo_apellido' => 'Rojas',
                'carrera_id' => 1, // Admin
                'celular' => '984373818',
                'fecha_nacimiento' => Carbon::parse('2006-10-27'),
                'user_id' => $this->createUser('Cielo Valentina', 'cvabantor@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1514000222',
                'dni' => '73817362',
                'primer_apellido' => 'Ullilén',
                'segundo_apellido' => 'Chávez',
                'carrera_id' => 30, // Ing Civil
                'celular' => '986643843',
                'fecha_nacimiento' => Carbon::parse('2003-05-25'),
                'user_id' => $this->createUser('Diego Jesús', 'diegoullilen250503@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1520100421',
                'dni' => '75710225',
                'primer_apellido' => 'Aguirre',
                'segundo_apellido' => 'Valverde',
                'carrera_id' => 1, // Admin
                'celular' => '927773230',
                'fecha_nacimiento' => Carbon::parse('2004-03-09'),
                'user_id' => $this->createUser('Emelyn Yasmin', 't1520100421@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1053200921',
                'dni' => '71642130',
                'primer_apellido' => 'Esquivel',
                'segundo_apellido' => 'Davila',
                'carrera_id' => 8, // CC Comunicación
                'celular' => '999226072',
                'fecha_nacimiento' => Carbon::parse('2003-10-27'),
                'user_id' => $this->createUser('Ghenary Tais', 't1053200921@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1030100523',
                'dni' => '74968545',
                'primer_apellido' => 'Hoyos',
                'segundo_apellido' => 'Terrones',
                'carrera_id' => 1, // Admin
                'celular' => '941100563',
                'fecha_nacimiento' => Carbon::parse('2006-01-28'),
                'user_id' => $this->createUser('Jakori Nayeli', 'jnhoyoste@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1024100421',
                'dni' => '74540788',
                'primer_apellido' => 'Robles',
                'segundo_apellido' => 'Solorzano',
                'carrera_id' => 5, // Arq y Urbanismo
                'celular' => '965207091',
                'fecha_nacimiento' => Carbon::parse('2024-08-02'),
                'user_id' => $this->createUser('Jordyna', 'T1024100421@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010101220',
                'dni' => '71245673',
                'primer_apellido' => 'Calle',
                'segundo_apellido' => 'Gutierrez',
                'carrera_id' => 1, // Admin
                'celular' => '918739639',
                'fecha_nacimiento' => Carbon::parse('2000-09-23'),
                'user_id' => $this->createUser('Jose Efrain', 't010101220@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1028100120',
                'dni' => '73501912',
                'primer_apellido' => 'Pérez',
                'segundo_apellido' => 'Rodríguez',
                'carrera_id' => 17,
                'celular' => '975607533',
                'fecha_nacimiento' => Carbon::parse('2002-07-16'),
                'user_id' => $this->createUser('Lesly Fiorella', 'perezrodriguezlesly791@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1011301422',
                'dni' => '75857054',
                'primer_apellido' => 'Lecca',
                'segundo_apellido' => 'Cortez',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '923106748',
                'fecha_nacimiento' => Carbon::parse('2004-10-10'),
                'user_id' => $this->createUser('Luis Angel', 'lleccac@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1013700623',
                'dni' => '72539178',
                'primer_apellido' => 'Palacios',
                'segundo_apellido' => 'Asto',
                'carrera_id' => 30, // Ing Ambiental
                'celular' => '903481554',
                'fecha_nacimiento' => Carbon::parse('2004-05-24'),
                'user_id' => $this->createUser('Maite', 'mpalaciosas@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                 'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1014000722',
                'dni' => '70988813',
                'primer_apellido' => 'Cárdenas',
                'segundo_apellido' => 'Hidalgo',
                'carrera_id' => 30, // Ing Civil
                'celular' => '902525060',
                'fecha_nacimiento' => Carbon::parse('2002-12-30'),
                'user_id' => $this->createUser('Maria Fernanda', 'Mcardenash@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1530100220',
                'dni' => '73248516',
                'primer_apellido' => 'Quiroz',
                'segundo_apellido' => 'Mestanza',
                'carrera_id' => 1, // Admin
                'celular' => '957688311',
                'fecha_nacimiento' => Carbon::parse('2002-01-23'),
                'user_id' => $this->createUser('Nathaly Silvana', 'T530100220@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1020101720',
                'dni' => '75821177',
                'primer_apellido' => 'Quiliche',
                'segundo_apellido' => 'Vásquez',
                'carrera_id' => 1, // Admin
                'celular' => '932767446',
                'fecha_nacimiento' => Carbon::parse('2001-12-19'),
                'user_id' => $this->createUser('Santos Medali', 't020101720@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510101221',
                'dni' => '75278193',
                'primer_apellido' => 'Gutierrez',
                'segundo_apellido' => 'Vega',
                'carrera_id' => 1, // Admin
                'celular' => '954666258',
                'fecha_nacimiento' => Carbon::parse('2002-06-25'),
                'user_id' => $this->createUser('Stefany Isabel', 't1510101221@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051301921',
                'dni' => '74417161',
                'primer_apellido' => 'Arizola',
                'segundo_apellido' => 'Rodríguez',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '913893025',
                'fecha_nacimiento' => Carbon::parse('2004-02-08'),
                'user_id' => $this->createUser('Stephanie Angeline', 't1051301921@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510102521',
                'dni' => '74482945',
                'primer_apellido' => 'Gonzales',
                'segundo_apellido' => 'Contreras',
                'carrera_id' => 1, // Admin
                'celular' => '915949656',
                'fecha_nacimiento' => Carbon::parse('2024-12-20'),
                'user_id' => $this->createUser('Yojhania Taitt', 't1510102521@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 3,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1452700121',
                'dni' => '73541426',
                'primer_apellido' => 'Arteaga',
                'segundo_apellido' => 'Rodríguez',
                'carrera_id' => 27, // NO EXISTE
                'celular' => '903289563',
                'fecha_nacimiento' => Carbon::parse('2004-03-10'),
                'user_id' => $this->createUser('Aarón Kaleb', 'hionta16@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1053701023',
                'dni' => '72533278',
                'primer_apellido' => 'Pereda',
                'segundo_apellido' => 'Cabanillas',
                'carrera_id' => 30, // Ing Ambiental
                'celular' => '952428778',
                'fecha_nacimiento' => Carbon::parse('2005-11-18'),
                'user_id' => $this->createUser('Abel Maximiliano', 'amperedaca@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'codigo' => '1051300222',
            //     'dni' => '72560073',
            //     'primer_apellido' => 'Velarde',
            //     'segundo_apellido' => 'Escobar',
            //     'carrera_id' => 34, // Ing Industrial
            //     'celular' => '904468591',
            //     'fecha_nacimiento' => Carbon::parse('2000-05-24'),
            //     'user_id' => $this->createUser('Alexandra Brighit', 'avelarde@unitru.edu.pe', null),
            //     'cargo_id' => 3,
            //     'area_id' => 1,
            //     'genero' => Genero::Femenino->value, // Usa el Enum para el género
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            [
                'codigo' => '1020101424',
                'dni' => '77511764',
                'primer_apellido' => 'Loayza',
                'segundo_apellido' => 'Gutierrez',
                'carrera_id' => 1, // Admin
                'celular' => '946457459',
                'fecha_nacimiento' => Carbon::parse('2005-12-04'),
                'user_id' => $this->createUser('Angela Xiomara', 'Axloayzag@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1054001023',
                'dni' => '72563979',
                'primer_apellido' => 'Alayo',
                'segundo_apellido' => 'Sifuentes',
                'carrera_id' => 30, // Ing Civil
                'celular' => '954818095',
                'fecha_nacimiento' => Carbon::parse('2005-09-23'),
                'user_id' => $this->createUser('Dalery Nicoll', 'nicollalayo5@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1511300123',
                'dni' => '75377702',
                'primer_apellido' => 'Sánchez',
                'segundo_apellido' => 'Cabrera',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '923175367',
                'fecha_nacimiento' => Carbon::parse('2003-02-22'),
                'user_id' => $this->createUser('Daniel Angel', 'dasanchezca@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1511301120',
                'dni' => '72422455',
                'primer_apellido' => 'Céspedes',
                'segundo_apellido' => 'Esquivel',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '924423798',
                'fecha_nacimiento' => Carbon::parse('2001-10-07'),
                'user_id' => $this->createUser('David Caleb', 'dacacees@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1020100121',
                'dni' => '71318284',
                'primer_apellido' => 'Mostacero',
                'segundo_apellido' => 'Lecca',
                'carrera_id' => 1, // Admin
                'celular' => '970573507',
                'fecha_nacimiento' => Carbon::parse('2001-01-17'),
                'user_id' => $this->createUser('Diego Alejandro', 't1020100121@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1011300422',
                'dni' => '73122203',
                'primer_apellido' => 'Gutierrez',
                'segundo_apellido' => 'Vasquez',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '975685440',
                'fecha_nacimiento' => Carbon::parse('2004-01-08'),
                'user_id' => $this->createUser('Diego Alonso', 'dgutierrezva@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1450100220',
                'dni' => '71198580',
                'primer_apellido' => 'Benavides',
                'segundo_apellido' => 'Rodríguez',
                'carrera_id' => 1, // Admin
                'celular' => '950951555',
                'fecha_nacimiento' => Carbon::parse('2002-11-07'),
                'user_id' => $this->createUser('Giancarlo José', 'gian07benarodri@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510100520',
                'dni' => '76682970',
                'primer_apellido' => 'Vela',
                'segundo_apellido' => 'Ocampo',
                'carrera_id' => 1, // Admin
                'celular' => '979177278',
                'fecha_nacimiento' => Carbon::parse('2000-12-19'),
                'user_id' => $this->createUser('Ivanna Sofia', 't510100520@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1053701922',
                'dni' => '71862255',
                'primer_apellido' => 'Espejo',
                'segundo_apellido' => 'Rodríguez',
                'carrera_id' => 30, // Ing Ambiental
                'celular' => '943634104',
                'fecha_nacimiento' => Carbon::parse('2002-12-28'),
                'user_id' => $this->createUser('Jeoselyn Maribel', 'jespejor@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051300621',
                'dni' => '71467211',
                'primer_apellido' => 'Amaya',
                'segundo_apellido' => 'Cáceda',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '935931038',
                'fecha_nacimiento' => Carbon::parse('2004-04-21'),
                'user_id' => $this->createUser('Lucía de Fátima', 'aclucia21@gmail.com', null), 
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051502222',
                'dni' => '70362801',
                'primer_apellido' => 'Huamán',
                'segundo_apellido' => 'Martínez',
                'carrera_id' => 37, // Ing Metalurgica
                'celular' => '935284970',
                'fecha_nacimiento' => Carbon::parse('2005-01-19'),
                'user_id' => $this->createUser('María Celine', 'celineehm51@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1521300223',
                'dni' => '76554062',
                'primer_apellido' => 'Herrera',
                'segundo_apellido' => 'Cerquin',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '986756970',
                'fecha_nacimiento' => Carbon::parse('2005-08-23'),
                'user_id' => $this->createUser('María Fernanda De La Caridad', 'mariafe.herrera.c@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1534000120',
                'dni' => '75736701',
                'primer_apellido' => 'Cardenas',
                'segundo_apellido' => 'Contreras',
                'carrera_id' => 30, // Ing Civil
                'celular' => '964987251',
                'fecha_nacimiento' => Carbon::parse('2002-05-11'),
                'user_id' => $this->createUser('Micaela Anthoaneth', 'micantho1105@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '3273300119',
                'dni' => '70487719',
                'primer_apellido' => 'Nuñez',
                'segundo_apellido' => 'Ortiz',
                'carrera_id' => 33, // Ing Sistemas
                'celular' => '944317781',
                'fecha_nacimiento' => Carbon::parse('2001-11-21'),
                'user_id' => $this->createUser('Renato Martin', 'Nunezortizrenato@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1051300821',
                'dni' => '71324932',
                'primer_apellido' => 'Alcántara',
                'segundo_apellido' => 'Toribio',
                'carrera_id' => 34, // Ing Industrial
                'celular' => '986031012',
                'fecha_nacimiento' => Carbon::parse('2003-04-12'),
                'user_id' => $this->createUser('Rubén Darío', 'rdalcantarat@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1010100820',
                'dni' => '75062701',
                'primer_apellido' => 'Gil',
                'segundo_apellido' => 'Toribio',
                'carrera_id' => 1, // Admin
                'celular' => '968127710',
                'fecha_nacimiento' => Carbon::parse('2001-05-02'),
                'user_id' => $this->createUser('Cinthya Soledad', 'cinthyagiltoribio7@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1, //PRESIDENCIA
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1052500521',
                'dni' => '60775617',
                'primer_apellido' => 'Seclen',
                'segundo_apellido' => 'Cespedes',
                'carrera_id' => 42, // Trabajo Social
                'celular' => '997951124',
                'fecha_nacimiento' => Carbon::parse('2002-11-10'),
                'user_id' => $this->createUser('Romina Alejandra', 'rominaalejandraseclen@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 1,  //VICEPRESIDENCIA
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'codigo' => '1053300720',
            //     'dni' => '72947835',
            //     'primer_apellido' => 'Cruz',
            //     'segundo_apellido' => 'Ulloa',
            //     'carrera_id' => 33, // Ing Sistemas
            //     'celular' => '994054491',
            //     'fecha_nacimiento' => Carbon::parse('1999-03-12'),
            //     'user_id' => $this->createUser('Anahy Estrella', 't053300720@unitru.edu.pe', null),
            //     'cargo_id' => 3,
            //     'area_id' => 4,
            //     'genero' => Genero::Femenino->value, // Usa el Enum para el género
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            [
                'codigo' => '1052701519',
                'dni' => '72226388',
                'primer_apellido' => 'Osorio', 
                'segundo_apellido' => 'Trujillo',
                'carrera_id' => 27, // NO EXISTE
                'celular' => '997748402',
                'fecha_nacimiento' => Carbon::parse('2000-09-09'),
                'user_id' => $this->createUser('Anthony Jhonatan', 'asibernauta@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1512700519',
                'dni' => '77207794',
                'primer_apellido' => 'Bamberger',
                'segundo_apellido' => 'Plasencia',
                'carrera_id' => 27,
                'celular' => '927556501',
                'fecha_nacimiento' => Carbon::parse('2000-04-03'),
                'user_id' => $this->createUser('Braggi Jayson', 'bbamberger@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 4,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1052700819',
                'dni' => '73179853',
                'primer_apellido' => 'Morales',
                'segundo_apellido' => 'Esquivel',
                'carrera_id' => 26, // Informatica
                'celular' => '949177350',
                'fecha_nacimiento' => Carbon::parse('2000-08-19'),
                'user_id' => $this->createUser('Christian Anthony', 'moralesesquivelchristian@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '151270122',
                'dni' => '74136358',
                'primer_apellido' => 'Liñer',
                'segundo_apellido' => 'Sagástegui',
                'carrera_id' => 26, // Informatica
                'celular' => '907579470',
                'fecha_nacimiento' => Carbon::parse('2003-05-22'),
                'user_id' => $this->createUser('Jean Pierre Camilo', 'jliner@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1012700620',
                'dni' => '72613310',
                'primer_apellido' => 'Morales',
                'segundo_apellido' => 'Lino',
                'carrera_id' => 26, // Informatica
                'celular' => '967111882',
                'fecha_nacimiento' => Carbon::parse('2002-11-24'),
                'user_id' => $this->createUser('Luis Angel', 't012700620@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 4,
                 'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1022700720',
                'dni' => '76847674',
                'primer_apellido' => 'Toledo',
                'segundo_apellido' => 'Campos',
                'carrera_id' => 26, // Informatica
                'celular' => '961988445',
                'fecha_nacimiento' => Carbon::parse('1999-10-12'),
                'user_id' => $this->createUser('MARCO CAMILO', 'martold.1210@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1052701019',
                'dni' => '71957561',
                'primer_apellido' => 'Gamboa',
                'segundo_apellido' => 'Valderrama',
                'carrera_id' => 26, // Informatica
                'celular' => '947810713',
                'fecha_nacimiento' => Carbon::parse('2001-04-10'),
                'user_id' => $this->createUser('Mirella Esteffany', 'mgamboav@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '3273301019',
                'dni' => '75704759',
                'primer_apellido' => 'Ulco',
                'segundo_apellido' => 'Chavarria',
                'carrera_id' => 33, // Ing Sistemas
                'celular' => '918812501',
                'fecha_nacimiento' => Carbon::parse('2000-08-26'),
                'user_id' => $this->createUser('Rommel Eduardo', 'rulco@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'qr_code' => 'SED-3273301019-e6c8f360-03a3c8ed',
                'qr_path' => 'qrcodes/SED-3273301019-e6c8f360-03a3c8ed.svg',
                'secret_key' => '303fbecd0b321a7562f5f2a1e7d90148899f4cd273a398365b8d3643853e8aab',
                'token' => 'e6c8f360-17a6-4a41-be39-8f06d235e5b2',
                'qr_hash' => '03a3c8ed241231b31694b1cc2d1675c795bd1b299d92455dc5009c8087834baf',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1012701020',
                'dni' => '72763429',
                'primer_apellido' => 'Rojas',
                'segundo_apellido' => 'García',
                'carrera_id' => 27, // NO EXISTE
                'celular' => '958766689',
                'fecha_nacimiento' => Carbon::parse('2002-04-07'),
                'user_id' => $this->createUser('Sadhú', 'andresrojas1234321@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1510101522',
                'dni' => '72572282',
                'primer_apellido' => 'Sanchez',
                'segundo_apellido' => 'Delgado',
                'carrera_id' => 1, // Admin
                'celular' => '991511044',
                'fecha_nacimiento' => Carbon::parse('2001-11-07'),
                'user_id' => $this->createUser('Corina Marilu', 'Csanchezd@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Femenino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1513702222',
                'dni' => '72223026',
                'primer_apellido' => 'Urtecho',
                'segundo_apellido' => 'Avila',
                'carrera_id' => 30, // Ing Ambiental
                'celular' => '917344623',
                'fecha_nacimiento' => Carbon::parse('2003-10-04'),
                'user_id' => $this->createUser('ANDRWEEU DANIEL', 'aurtechoa@gmail.com', null),
                'cargo_id' => 3,
                'area_id' => 5,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => '1052700520',
                'dni' => '77281057',
                'primer_apellido' => 'Lazaro',
                'segundo_apellido' => 'Solano',
                'carrera_id' => 27, // Informatica
                'celular' => '944377799',
                'fecha_nacimiento' => Carbon::parse('2001-05-11'),
                'user_id' => $this->createUser('Paul Jamir', 'T052700520@unitru.edu.pe', null),
                'cargo_id' => 3,
                'area_id' => 4,
                'genero' => Genero::Masculino->value, // Usa el Enum para el género
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];


        foreach ($sedipranosData as $data) {
            DB::table('sedipranos')->insert($data);
        }

        // $this->command->info('¡Datos de sedipranos importados exitosamente!');
    }

    /**
     * Crea un usuario si no existe, o devuelve el ID del usuario existente.
     *
     * @param string $name
     * @param string $email
     * @param string|null $password
     * @return int
     */
    private function createUser(string $name, string $email, string $password = null): int
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password ? Hash::make($password) : null,  // Contraseña null
            ]);
        }

        return $user->id;
    }
}
