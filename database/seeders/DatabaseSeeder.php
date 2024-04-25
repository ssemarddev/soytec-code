<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ariel Eliezer',
            'lastName' => 'Leyva Gutiérrez',
            'avatar' => 'avatar_12.jpg',
            'username' => 'ArielEliezer',
            'password' => bcrypt('gWCXR3Y8'),
            'email' => 'arieleliezer@gmail.com',
            'phone' => '+53 58091603',
            'gender' => 'Masculino',
            'level' => 'Administrador',
            'state' => 'Activa'
        ]);

        DB::table('clients')->insert([
            ['name' => 'Ana Maris', 'lastName' => 'López Gallardo', 'email' => 'anamaris@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 58091603', 'province' => 'Santiago de Cuba', 'city' => 'Santiago de Cuba', 'address' => 'Calle 20 #106 entre calle 5 y calle 7. Reparto Dessy', 'state' => 'Activa', 'avatar' => 'users/1.jpg'],
            ['name' => 'Alfonso', 'lastName' => 'Zarza Izalde', 'email' => 'alfonsozarza@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 54258796', 'province' => 'Idaho', 'city' => 'West Hoyt', 'address' => '1639 Wilhelm Route, Apt. 773, 62542-3316', 'state' => 'Bloqueada', 'avatar' => 'users/2.jpg'],
            ['name' => 'Reinaldo', 'lastName' => 'Tamayo Álvarez', 'email' => 'reynaldo.tamayo@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 56358741', 'province' => 'Idaho', 'city' => 'North Estefania', 'address' => '576 Reinhold Canyon, Apt. 592, 42320-9514', 'state' => 'Activa', 'avatar' => 'users/3.jpg'],
            ['name' => 'Fernanda María', 'lastName' => 'Hernández López', 'email' => 'mariafdez@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 59684785', 'province' => 'New Mexico', 'city' => 'New Mary', 'address' => '329 Bailey Heights, Suite 706, 66714', 'state' => 'Activa', 'avatar' => 'users/4.jpg'],
            ['name' => 'Pedro Armando', 'lastName' => 'Matute Rodríguez', 'email' => 'fdezmariamaturerodriguez@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 54123668', 'province' => 'Kansas', 'city' => 'Lake Valentine', 'address' => '337 Hansen Hills, Apt. 383, 69222', 'state' => 'Bloqueada', 'avatar' => 'users/5.jpg'],
            ['name' => 'Elena', 'lastName' => 'Quevent Godinez', 'email' => 'elenagodinez@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 57145236', 'province' => 'Hawaii', 'city' => 'Lake Arch', 'address' => '811 Smitham Forks, Apt. 023, 75508', 'state' => 'Activa', 'avatar' => 'users/6.jpeg'],
            ['name' => 'Victoria Sofía', 'lastName' => 'Soto Prada', 'email' => 'sotoprada.sofia@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 51254785', 'province' => 'Kansas', 'city' => 'Lake Valentine', 'address' => '337 Hansen Hills, Apt. 383, 69222', 'state' => 'Bloqueada', 'avatar' => 'users/7.jpeg'],
            ['name' => 'Yelena', 'lastName' => 'Aguilar Hernández', 'email' => 'yeleaguilar@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 53251236', 'province' => 'Nevada', 'city' => 'West Annaside', 'address' => '64355 Boyle Landing, Apt. 846, 84432', 'state' => 'Activa', 'avatar' => 'users/8.jpeg'],
            ['name' => 'Juan Ernesto', 'lastName' => 'Guerra Agüero', 'email' => 'guerraernesto@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 54893781', 'province' => 'Massachusetts', 'city' => 'Port Melyssamouth', 'address' => '75203 Harber Vista, Suite 221, 82181-7603', 'state' => 'Activa', 'avatar' => 'users/9.jpg'],
            ['name' => 'Margarita', 'lastName' => 'Segura Roa', 'email' => 'margarita.roa@gmail.com', 'password' => bcrypt('gWCXR3Y8'), 'gender' => 'Femenino', 'phone' => '+53 59972853', 'province' => 'Texas', 'city' => 'Port Ansley', 'address' => '01427 Okey Way, Apt. 155, 14758', 'state' => 'Bloqueada', 'avatar' => 'users/10.jpg'],
        ]);

        DB::table('categories')->insert([
            ["id" => "1", "name" => "Gammer", "description" => "Productos y accesorios Gammer.", "state" => "Activa"],
            ["id" => "2", "name" => "Accesorios", "description" => "Accesorios para dispositivos de sonido, teléfonos inteligentes y más.", "state" => "Activa"],
            ["id" => "4", "name" => "Cables y Hubs usb", "description" => "Cables variados y conectores USB de gran utilidad", "state" => "Activa"],
            ["id" => "5", "name" => "Componentes de  PC", "description" => "Todas las piezas de un computador de escritorio al alcance de un click.", "state" => "Inactiva"],
            ["id" => "6", "name" => "Conectividad y Redes", "description" => "Equipos y accesorios para conectarse a internet e intranet", "state" => "Activa"],
            ["id" => "7", "name" => "Impresión", "description" => "Dispositivos de impresión y piezas de repuesto", "state" => "Activa"],
            ["id" => "8", "name" => "Laptops y Accesorios", "description" => "Buscas un equipo confiable portable, sin dudas en esta categoría encontrarás eso y más", "state" => "Activa"],
            ["id" => "9", "name" => "Perifericos de PC", "description" => "Dispositivos periféricos para PC (teclados, mouse, altavoces, etc)", "state" => "Activa"],
            ["id" => "10", "name" => "Software", "description" => "Necesitas algún software en específico, puedes echar un vistazo por acá, quizás encuentres los que buscas", "state" => "Activa"],
            ["id" => "11", "name" => "Accesorios Pc Gamming", "description" => "Accesorios para tu PC gammer, mejora y haz lucir tu bestia con estos dispositivos", "state" => "Inactiva"],
            ["id" => "12", "name" => "Consolas", "description" => "Nada mejor que una gran partdadespués de un largo día", "state" => "Activa"],
            ["id" => "13", "name" => "Repuestos", "description" => "Piezas de repuesto de todo tipo, para diferentes dispositivos, dale vida a tus equipos", "state" => "Inactiva"],
            ["id" => "14", "name" => "Accesorios Para Camaras", "description" => "Una imagen perfecta es fácil de lograr con estos accesorios para tu cámara profesional", "state" => "Activa"],
            ["id" => "15", "name" => "Otros", "description" => "Aquí encontrarás productos variados", "state" => "Activa"],
            ["id" => "16", "name" => "Smartphones", "description" => "Teléfono inteligentes.", "state" => "Inactiva"]
        ]);

        DB::table('products')->insert([
            ["name" => "Galaxy Tab", "code" => "23685896585", "sku" => "365", "description" => "Esse nostrud eiusmod aliqua nostrud dolore sint.", "cost" => 368, "price" => 379, "stock" => 7, "min" => 3, "image" => "products/Hmuf0gHd5ijjPR5HJjHSu6D1nExAEiSLDqMOpGoH.jpg", "model" => "Galaxy Tab-HL45a", "trademark" => "Samsung", "type" => "Físico", "category_id" => 16, "state" => "Activo", "tags" => "Smartphone,Cargador,Táctil"],
            ["name" => "Laptop HP", "code" => "2359874596", "sku" => "125", "description" => "Proident qui adipisicing laboris sit deserunt laborum consectetur.", "cost" => 478, "price" => 499, "stock" => 3, "min" => 1, "image" => "products/VeDF5rONx2eVFhUgU6Lgi90qKEmVrWLy3agGzras.jpg", "model" => "HP-589SD", "trademark" => "HP", "type" => "Físico", "category_id" => 15, "state" => "Activo", "tags" => "PC,Laptop,Cargador,Batería"],
            ["name" => "Motorola", "code" => "6325874159", "sku" => "259", "description" => "Laboris reprehenderit id et anim sit.", "cost" => 400, "price" => 429, "stock" => 5, "min" => 2, "image" => "products/aosaBflS6w78fUqAXWd8XXPmGguNs6KaeHe6EgqA.jpg", "model" => "LOP-58961", "trademark" => "Motorola", "type" => "Físico", "category_id" => 16, "state" => "Activo", "tags" => "Smarphone,Batería,Teléfono,Audífonos,Cargador"],
            ["name" => "Soporte de Pantallas", "code" => "1458759630", "sku" => "368", "description" => "Aliqua quis dolore magna consectetur sunt proident sint non sunt.", "cost" => 135, "price" => 169, "stock" => 10, "min" => 2, "image" => "products/XAtYoPhgu88Tepxkg7VcFkSLvuqyTGnyET0g3hdL.jpg", "model" => "M2-PSOL", "trademark" => "Fopo", "type" => "Físico", "category_id" => 1, "state" => "Activo", "tags" => "Monitor,Laptop,Pantalla"],
            ["name" => "Tarjeta de vídeo", "code" => "5689512032", "sku" => "687", "description" => "Esse quis exercitation ut aute nisi voluptate aliqua ullamco labore sunt non ipsum fugiat.", "cost" => 468, "price" => 499, "stock" => 15, "min" => 6, "image" => "products/9qZK1qbl1ZxKBdv8uB6hYtCwy0X114seGf7KF04t.png", "model" => "GTX-3070 TI", "trademark" => "Nividia", "type" => "Físico", "category_id" => 1, "state" => "Activo", "tags" => "Gammer,Videojuego,PC"],
            ["name" => "Cámara profesional", "code" => "4859623014", "sku" => "751", "description" => "Ullamco proident fugiat qui reprehenderit consequat amet aliquip cupidatat cillum in eiusmod.", "cost" => 786, "price" => 919, "stock" => 3, "min" => 1, "image" => "products/E5F1kP6nkglx5yFGOHqI7PEgKhDIZu7bszKU7ikh.jpg", "model" => "LF-87x", "trademark" => "Nikon", "type" => "Físico", "category_id" => 15, "state" => "Activo", "tags" => "Fotografía,Diseño,Imagen,PC"],
            ["name" => "Audífonos inalámbricos", "code" => "3658958745", "sku" => "310", "description" => "Magna consectetur enim eu velit sunt aliquip dolore occaecat est do excepteur.", "cost" => 46, "price" => 59, "stock" => 125, "min" => 15, "image" => "products/of2Ef5zBqZFCQfVkkfVqtoCSGxfN1bVweR32Y8eP.jpg", "model" => "Hyper-X", "trademark" => "JBL", "type" => "Físico", "category_id" => 16, "state" => "Activo", "tags" => "Audio,Música,Smartphone,Batería,Cargador"]
        ]);
        DB::table('quotations')->insert([
            ["client_id" => 1, "name" => "Arreglo de smartphone", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 2, "name" => "Cambio de batería de laptop", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 5, "name" => "Mantenimiento de PC", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 3, "name" => "Arreglo de monitor", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 4, "name" => "Cambio de pantalla de Laptop", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 8, "name" => "Adición de fanes RGB a PC", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 2, "name" => "Arreglo del interruptor de smartphone", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 1, "name" => "Enmallado de cables de fuente de corriente", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            ["client_id" => 3, "name" => "Cammbio de memoria RAM a placa base", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."]
        ]);

        DB::table('services')->insert([
            ["quotation_id" => 1, "name" => "Cambio del botón de encendido", "description" => "Interruptor de plástico negro\nInterruptor modelo SM-P47\nIP-69", "cost" => 580, "time" => 54],
            ["quotation_id" => 1, "name" => "Mantenimiento al Software", "description" => "Limpiza de archivos del sistema orperativo\nEncryptar tarjeta SD para proteger archivos de copia de seguridad", "cost" => 55, "time" => 60],
            ["quotation_id" => 2, "name" => "Instalación de batería", "description" => "Batería de litio de 5400 Miliamperios\nDuración aproximada: 8horas\nBatería modelo IO-87S", "cost" => 8750, "time" => 20],
            ["quotation_id" => 2, "name" => "Limpieza del dispositivo", "description" => "No relevante", "cost" => 510, "time" => 45],
            ["quotation_id" => 2, "name" => "Cambio de puerto USB dañado", "description" => "Puerto USB 3.0", "cost" => 320, "time" => 40],
            ["quotation_id" => 3, "name" => "Limpieza y mantenimiento de componentes", "description" => "No relevante", "cost" => 640, "time" => 60],
            ["quotation_id" => 4, "name" => "Cambio de Flyback", "description" => "Flyback marca AOpen\nModelo 314SD-987s", "cost" => 9870, "time" => 35],
            ["quotation_id" => 4, "name" => "Recalibración de colores", "description" => "No relevante", "cost" => 580, "time" => 10],
            ["quotation_id" => 5, "name" => "Reemplazo de pantalla", "description" => "Display táctil\nDisplay marca SyncMaster Samsung\Display de 14'", "cost" => 14500, "time" => 20],
            ["quotation_id" => 5, "name" => "Arreglo de display roto", "description" => "Reemplazo de fusible en mal estado", "cost" => 540, "time" => 14],
            ["quotation_id" => 6, "name" => "Instalación de fanes", "description" => "8 Fanes RGB de 6'\nFanes de 6500 R/min", "cost" => 870, "time" => 50],
            ["quotation_id" => 7, "name" => "Instalación del nuevo interruptor", "description" => "Interruptor modelo TL-5745\nInterruptor no IP-69", "cost" => 250, "time" => 35],
            ["quotation_id" => 7, "name" => "Mantenimiento del Software", "description" => "Instalación de aplicaciones\nInstalacion de antivirus\Limpieza de archivos innecesarios", "cost" => 500, "time" => 30],
            ["quotation_id" => 8, "name" => "Remplazo de cable defectuoso", "description" => "Cable de 12V rojo", "cost" => 100, "time" => 20],
            ["quotation_id" => 8, "name" => "Enmallado de cables", "description" => "Enmallado de tela de vidrio negra\nMaterial resistente al calor", "cost" => 780, "time" => 30],
            ["quotation_id" => 9, "name" => "Instalación de memoria RAM", "description" => "Memoria RAM de 16GB\nMemoria RAM modelo DDR-4\nMemoria RAM disipada marca Kingston\nModelo PO15-2600MHz", "cost" => 5000, "time" => 12],
        ]);

        DB::table('repairs')->insert([
            ["name" => "Smartphone Samsung", "reference" => "3658g4f47s2s", "contact" => "+53 58745896", "price" => 500, "payType" => "Paypal", "state" => "Listo para recoger", "finished" => "2023-06-10 12:25", "tags" => "Smartphone,Android,Cargador,Cable de datos", 'created_at' => '2023-06-04'],
            ["name" => "Monitor AOpen", "reference" => "p6skg4f4sp2p", "contact" => "+53 52147895", "price" => 635, "payType" => "Stripe", "state" => "Instalando el display", "finished" => "2023-06-25 09:30", "tags" => "Monitor,Accesorio,PC", 'created_at' => '2023-06-01'],
            ["name" => "Fuente de PC", "reference" => "3sp8gsk47s2s", "contact" => "+53 56328743", "price" => 4785, "payType" => "Paypal", "state" => "Reemplazando el cable de 12V dañado", "finished" => "2023-06-23 14:10", "tags" => "Fuente de PC,PC,Chasis", 'created_at' => '2023-06-03'],
            ["name" => "Placa base Asus", "reference" => "3658p4ssps2s", "contact" => "+53 59874235", "price" => 560, "payType" => "Efectivo", "state" => "Listo para recoger", "finished" => "2023-06-09 13:25", "tags" => "Placa base,PC,CPU,RAM", 'created_at' => '2023-06-04'],
            ["name" => "Smartphone I-Phone", "reference" => "3sk8g4spps2s", "contact" => "+53 52147535", "price" => 540, "payType" => "Efectivo", "state" => "Instalación del interruptor", "finished" => "2023-06-13 08:40", "tags" => "Smartphone,IOS,Cargador,Cable de datos", 'created_at' => '2023-05-29'],
            ["name" => "Mouse Logitech", "reference" => "sk58g4f4psps", "contact" => "+53 59365896", "price" => 630, "payType" => "Paypal", "state" => "En mantenimiento", "finished" => "2023-06-20 16:25", "tags" => "Mouse,Gammer,Teclado,RGB,PC", 'created_at' => '2023-06-02'],
            ["name" => "Teclado RGB", "reference" => "p658g4sksp2s", "contact" => "+53 52247851", "price" => 570, "payType" => "Mercado Pago", "state" => "Listo para recoger", "finished" => "2023-06-12 16:45", "tags" => "Teclado,Gammer,Mouse,RBG,PC", 'created_at' => '2023-05-05'],
            ["name" => "Chasis XTech", "reference" => "3658g4pssp2s", "contact" => "+53 51258963", "price" => 900, "payType" => "Mercado Pago", "state" => "Listo para recoger", "finished" => "2023-06-15 11:00", "tags" => "Chasis,Gammer,PC", 'created_at' => '2023-06-04'],
        ]);

        DB::table('reviews')->insert([
            ["client_id" => 1, "review" => 4, "comment" => "Exclente servicio, una atención esmerada", "confirmed" => true],
            ["client_id" => 4, "review" => 5, "comment" => "Muy buen servicio por parte de todo el equipo de trabajo, en unos pocos días tuve de vuelta mi dispositivo", "confirmed" => false],
            ["client_id" => 6, "review" => 3, "comment" => "Estuvo muy bueno el servicio de reparación pero recomiendo tener más variedad de productos en la tienda", "confirmed" => true],
            ["client_id" => 5, "review" => 4, "comment" => "Excelente!!", "confirmed" => true],
            ["client_id" => 2, "review" => 5, "comment" => "Estupedo, muy rápido, es muy bueno el servicio de atención y segumiento en la web, súper cómodo, los felicito!!!", "confirmed" => true],
            ["client_id" => 3, "review" => 1, "comment" => "Pésimo servicio no vuelvo más", "confirmed" => false],
        ]);

        DB::table('sales')->insert([
            ["client_id" => 1, "price" => 540, "tax" => 50, "total" => 590, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-04-25'],
            ["client_id" => 2, "price" => 5300, "tax" => 0, "total" => 5300, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-04-28'],
            ["client_id" => 5, "price" => 540, "tax" => 0, "total" => 540, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-04-29'],
            ["client_id" => 1, "price" => 540, "tax" => 50, "total" => 590, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-05-03'],
            ["client_id" => 2, "price" => 5300, "tax" => 0, "total" => 5300, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-05-05'],
            ["client_id" => 5, "price" => 540, "tax" => 0, "total" => 540, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-05-12'],
            ["client_id" => 4, "price" => 36000, "tax" => 50, "total" => 36050, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-05-12'],
            ["client_id" => 4, "price" => 36000, "tax" => 10, "total" => 36010, "payType" => "Mercado Pago", "state" => "Por entregar", 'created_at' => '2023-05-13'],
            ["client_id" => 2, "price" => 30, "tax" => 50, "total" => 80, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-05-14'],
            ["client_id" => 3, "price" => 540, "tax" => 10, "total" => 550, "payType" => "Mercado Pago", "state" => "Entregado", 'created_at' => '2023-05-15'],
            ["client_id" => 4, "price" => 580, "tax" => 50, "total" => 630, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-05-17'],
            ["client_id" => 8, "price" => 10500, "tax" => 10, "total" => 10510, "payType" => "Mercado Pago", "state" => "Por entregar", 'created_at' => '2023-05-20'],
            ["client_id" => 8, "price" => 580, "tax" => 10, "total" => 590, "payType" => "Mercado Pago", "state" => "Por entregar", 'created_at' => '2023-05-22'],
            ["client_id" => 2, "price" => 5300, "tax" => 0, "total" => 5300, "payType" => "Efectivo", "state" => "Entregado", 'created_at' => '2023-05-22'],
            ["client_id" => 3, "price" => 540, "tax" => 0, "total" => 540, "payType" => "Efectivo", "state" => "Entregado", 'created_at' => '2023-05-23'],
            ["client_id" => 4, "price" => 10500, "tax" => 60, "total" => 10560, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-05-24'],
            ["client_id" => 10, "price" => 3200, "tax" => 0, "total" => 3200, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-05-15'],
            ["client_id" => 9, "price" => 5300, "tax" => 50, "total" => 5350, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-01'],
            ["client_id" => 5, "price" => 360, "tax" => 60, "total" => 420, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-02'],
            ["client_id" => 4, "price" => 5300, "tax" => 0, "total" => 5300, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-06-02'],
            ["client_id" => 2, "price" => 540, "tax" => 50, "total" => 590, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-04'],
            ["client_id" => 3, "price" => 360, "tax" => 10, "total" => 370, "payType" => "Mercado Pago", "state" => "Por entregar", 'created_at' => '2023-06-06'],
            ["client_id" => 1, "price" => 250, "tax" => 60, "total" => 310, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-06'],
            ["client_id" => 4, "price" => 500, "tax" => 0, "total" => 500, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-06-08'],
            ["client_id" => 5, "price" => 250, "tax" => 50, "total" => 300, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-09'],
            ["client_id" => 3, "price" => 780, "tax" => 60, "total" => 840, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-10'],
            ["client_id" => 7, "price" => 500, "tax" => 20, "total" => 520, "payType" => "Stripe", "state" => "Por entregar", 'created_at' => '2023-06-10'],
            ["client_id" => 8, "price" => 780, "tax" => 60, "total" => 840, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-11'],
            ["client_id" => 8, "price" => 5300, "tax" => 10, "total" => 5310, "payType" => "Mercado Pago", "state" => "Por entregar", 'created_at' => '2023-06-12'],
            ["client_id" => 8, "price" => 5800, "tax" => 20, "total" => 5820, "payType" => "Stripe", "state" => "Por entregar", 'created_at' => '2023-06-15'],
            ["client_id" => 3, "price" => 3200, "tax" => 60, "total" => 3260, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-16'],
            ["client_id" => 6, "price" => 320, "tax" => 60, "total" => 380, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-19'],
            ["client_id" => 4, "price" => 780, "tax" => 0, "total" => 780, "payType" => "Efectivo", "state" => "Entregado", 'created_at' => '2023-06-20'],
            ["client_id" => 7, "price" => 5800, "tax" => 60, "total" => 5860, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-22'],
            ["client_id" => 1, "price" => 3200, "tax" => 20, "total" => 3220, "payType" => "Stripe", "state" => "Entregado", 'created_at' => '2023-06-25'],
            ["client_id" => 2, "price" => 320, "tax" => 20, "total" => 340, "payType" => "Stripe", "state" => "Entregado", 'created_at' => '2023-06-29'],
            ["client_id" => 2, "price" => 368, "tax" => 50, "total" => 418, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-02'],
            ["client_id" => 3, "price" => 687, "tax" => 60, "total" => 747, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-03'],
            ["client_id" => 5, "price" => 987, "tax" => 0, "total" => 987, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-06-04'],
            ["client_id" => 7, "price" => 540, "tax" => 50, "total" => 590, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-05'],
            ["client_id" => 8, "price" => 698, "tax" => 10, "total" => 708, "payType" => "Mercado Pago", "state" => "Por entregar", 'created_at' => '2023-06-05'],
            ["client_id" => 2, "price" => 854, "tax" => 60, "total" => 914, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-07'],
            ["client_id" => 1, "price" => 500, "tax" => 0, "total" => 500, "payType" => "Efectivo", "state" => "Por entregar", 'created_at' => '2023-06-30'],
            ["client_id" => 3, "price" => 378, "tax" => 50, "total" => 437, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-09'],
            ["client_id" => 4, "price" => 478, "tax" => 60, "total" => 538, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-11'],
            ["client_id" => 5, "price" => 536, "tax" => 20, "total" => 556, "payType" => "Stripe", "state" => "Por entregar", 'created_at' => '2023-06-29'],
            ["client_id" => 6, "price" => 365, "tax" => 60, "total" => 375, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-13'],
            ["client_id" => 7, "price" => 985, "tax" => 10, "total" => 985, "payType" => "Mercado Pago", "state" => "Por entregar", 'created_at' => '2023-06-14'],
            ["client_id" => 8, "price" => 698, "tax" => 20, "total" => 718, "payType" => "Stripe", "state" => "Por entregar", 'created_at' => '2023-06-14'],
            ["client_id" => 9, "price" => 458, "tax" => 60, "total" => 508, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-17'],
            ["client_id" => 9, "price" => 690, "tax" => 60, "total" => 750, "payType" => "Paypal", "state" => "Entregado", 'created_at' => '2023-06-17'],
            ["client_id" => 3, "price" => 583, "tax" => 0, "total" => 583, "payType" => "Efectivo", "state" => "Entregado", 'created_at' => '2023-06-18'],
            ["client_id" => 4, "price" => 473, "tax" => 60, "total" => 533, "payType" => "Paypal", "state" => "Por entregar", 'created_at' => '2023-06-19'],
            ["client_id" => 2, "price" => 891, "tax" => 20, "total" => 911, "payType" => "Stripe", "state" => "Entregado", 'created_at' => '2023-06-20'],
            ["client_id" => 1, "price" => 632, "tax" => 20, "total" => 652, "payType" => "Stripe", "state" => "Entregado", 'created_at' => '2023-06-28'],
        ]);

        DB::table('sold_products')->insert([
            ['sale_id' => 1, 'product_id' => 1, 'quantity' => 1],
            ['sale_id' => 2, 'product_id' => 2, 'quantity' => 2],
            ['sale_id' => 2, 'product_id' => 4, 'quantity' => 1],
            ['sale_id' => 6, 'product_id' => 3, 'quantity' => 4],
            ['sale_id' => 6, 'product_id' => 1, 'quantity' => 3],
            ['sale_id' => 6, 'product_id' => 2, 'quantity' => 2],
            ['sale_id' => 8, 'product_id' => 4, 'quantity' => 3],
            ['sale_id' => 10, 'product_id' => 5, 'quantity' => 2],
            ['sale_id' => 15, 'product_id' => 5, 'quantity' => 1],
            ['sale_id' => 15, 'product_id' => 3, 'quantity' => 3],
            ['sale_id' => 16, 'product_id' => 1, 'quantity' => 5],
            ['sale_id' => 3, 'product_id' => 1, 'quantity' => 4],
            ['sale_id' => 3, 'product_id' => 2, 'quantity' => 3],
            ['sale_id' => 4, 'product_id' => 4, 'quantity' => 1],
            ['sale_id' => 5, 'product_id' => 3, 'quantity' => 2],
            ['sale_id' => 5, 'product_id' => 1, 'quantity' => 2],
            ['sale_id' => 7, 'product_id' => 2, 'quantity' => 4],
            ['sale_id' => 7, 'product_id' => 4, 'quantity' => 5],
            ['sale_id' => 11, 'product_id' => 5, 'quantity' => 10],
            ['sale_id' => 11, 'product_id' => 5, 'quantity' => 3],
            ['sale_id' => 11, 'product_id' => 3, 'quantity' => 4],
            ['sale_id' => 11, 'product_id' => 1, 'quantity' => 2]
        ]);

        DB::table('permissions')->insert([
            ['permission' => 'root', 'name' => 'Acceso completo'],
            ['permission' => 'categories-read', 'name' => 'Ver categorías'],
            ['permission' => 'categories-write', 'name' => 'Editar categorías'],
            ['permission' => 'clients-read', 'name' => 'Ver clientes'],
            ['permission' => 'clients-write', 'name' => 'Editar clientes'],
            ['permission' => 'products-read', 'name' => 'Ver productos'],
            ['permission' => 'products-write', 'name' => 'Editar productos'],
            ['permission' => 'sales-read', 'name' => 'Ver ventas'],
            ['permission' => 'sales-write', 'name' => 'Editar ventas'],
            ['permission' => 'repairs-read', 'name' => 'Ver equipos del taller'],
            ['permission' => 'repairs-write', 'name' => 'Editar equipos del taller'],
            ['permission' => 'users-read', 'name' => 'Ver administradores'],
            ['permission' => 'users-write', 'name' => 'Editar administradores'],
            ['permission' => 'quotations-read', 'name' => 'Ver cotizaciones'],
            ['permission' => 'quotations-write', 'name' => 'Editar cotizaciones'],
            ['permission' => 'reviews-read', 'name' => 'Ver reseñas'],
            ['permission' => 'reviews-write', 'name' => 'Editar reseñas'],
            ['permission' => 'providers-read', 'name' => 'Ver los proveedores'],
            ['permission' => 'providers-write', 'name' => 'Editar los datos de proveedores'],
            ['permission' => 'pieces-read', 'name' => 'Consultar el inventario'],
            ['permission' => 'pieces-write', 'name' => 'Editar el inventario'],
            ['permission' => 'shopping-read', 'name' => 'Ver las compras realizadas'],
            ['permission' => 'shopping-write', 'name' => 'Agregar y eliminar compras'],
        ]);

        DB::table('user_permissions')->insert([
            ['user_id' => 1, 'permission_id' => 1]
        ]);

        DB::table('providers')->insert([
            [
                'name' => 'Repuestos Málaga S.A',
                'address' => '1639 Wilhelm Route, Apt. 773, 62542-3316. West Hoyt, Idaho',
                'email' => 'clients@respuestosmalaga.com',
                'phone' => '+53 58091603',
                'website' => 'https://www.repuestosmalaga.com'
            ],
            [
                'name' => 'Hernández & Asociados',
                'address' => '337 Hansen Hills, Apt. 383, 69222. Lake Valentine, Kansas',
                'email' => 'contact@hdez.com',
                'phone' => '+53 58934756',
                'website' => 'https://www.clients.hdez.com'
            ],
        ]);

        DB::table('units')->insert([
            ['name' => 'Gramos', 'type' => 'Peso'],
            ['name' => 'Kilogramos', 'type' => 'Peso'],
            ['name' => 'Libras', 'type' => 'Peso'],
            ['name' => 'Onzas', 'type' => 'Peso'],
            ['name' => 'Toneladas', 'type' => 'Peso'],
            ['name' => 'Decilitros', 'type' => 'Volumen'],
            ['name' => 'Litros', 'type' => 'Volumen'],
            ['name' => 'Mililitros', 'type' => 'Volumen'],
            ['name' => 'Milímetros cúbicos', 'type' => 'Volumen'],
            ['name' => 'Centímetros', 'type' => 'Longitud'],
            ['name' => 'Milímetros', 'type' => 'Longitud'],
            ['name' => 'Metros', 'type' => 'Longitud'],
            ['name' => 'Pulgadas', 'type' => 'Longitud'],
            ['name' => 'Kilómetros', 'type' => 'Longitud'],
            ['name' => 'Unidades', 'type' => 'Cantidad'],
            ['name' => 'Frascos', 'type' => 'Cantidad'],
            ['name' => 'Pomos', 'type' => 'Cantidad'],
        ]);

        DB::table('pieces')->insert([
            ['name' => 'Pantallas', 'model' => 'Samsung J7SM-22', 'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione ad possimus modi repellendus? Expedita, vitae rerum at aliquam eligendi soluta veniam ut dolor facere fugiat quod, maxime ad accusamus quisquam.', 'stock' => 3, 'unit_id' => 15],
            ['name' => 'Cámaras', 'model' => 'Xiaomi Redmi Note 8', 'description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione ad possimus modi repellendus? Expedita, vitae rerum at aliquam eligendi soluta veniam ut dolor facere fugiat quod, maxime ad accusamus quisquam.', 'stock' => 15, 'unit_id' => 15]
        ]);

        DB::table('shoppings')->insert([
            ['piece_id' => 1, 'user_id' => 1, 'provider_id' => 1, 'quantity' => 3, 'cost' => 1532],
            ['piece_id' => 2, 'user_id' => 1, 'provider_id' => 2, 'quantity' => 11, 'cost' => 2750],
            ['piece_id' => 2, 'user_id' => 1, 'provider_id' => 1, 'quantity' => 4, 'cost' => 1125],
        ]);

        DB::table('events')->insert([
            ['date' => '2023-05-15', 'name' => 'Anim dolor exercitation', 'start' => '08:00', 'end' => '09:30'],
            ['date' => '2023-05-12', 'name' => 'Anim dolor exercitation', 'start' => '09:30', 'end' => '14:30'],
            ['date' => '2023-05-13', 'name' => 'Anim dolor exercitation', 'start' => '15:00', 'end' => '16:00'],
            ['date' => '2023-05-15', 'name' => 'Anim dolor exercitation', 'start' => '10:00', 'end' => '11:30'],
            ['date' => '2023-05-10', 'name' => 'Anim dolor exercitation', 'start' => '16:00', 'end' => '16:30'],
            ['date' => '2023-05-11', 'name' => 'Anim dolor exercitation', 'start' => '11:00', 'end' => '12:00'],
            ['date' => '2023-05-11', 'name' => 'Anim dolor exercitation', 'start' => '08:00', 'end' => '09:30'],
            ['date' => '2023-06-02', 'name' => 'Anim dolor exercitation', 'start' => '09:00', 'end' => '09:30'],
            ['date' => '2023-06-03', 'name' => 'Anim dolor exercitation', 'start' => '09:30', 'end' => '14:30'],
            ['date' => '2023-06-10', 'name' => 'Anim dolor exercitation', 'start' => '12:00', 'end' => '13:00'],
            ['date' => '2023-06-11', 'name' => 'Anim dolor exercitation', 'start' => '13:00', 'end' => '14:30'],
            ['date' => '2023-06-12', 'name' => 'Anim dolor exercitation', 'start' => '08:00', 'end' => '10:30'],
            ['date' => '2023-06-12', 'name' => 'Anim dolor exercitation', 'start' => '13:00', 'end' => '17:00'],
            ['date' => '2023-06-25', 'name' => 'Anim dolor exercitation', 'start' => '09:00', 'end' => '09:30'],
            ['date' => '2023-06-26', 'name' => 'Anim dolor exercitation', 'start' => '16:00', 'end' => '16:30'],
            ['date' => '2023-06-26', 'name' => 'Anim dolor exercitation', 'start' => '09:00', 'end' => '12:00'],
            ['date' => '2023-06-28', 'name' => 'Anim dolor exercitation', 'start' => '08:00', 'end' => '09:30'],
        ]);
    }
}
