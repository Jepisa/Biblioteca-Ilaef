<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\City;
use App\Models\Counter;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Language;
use App\Models\Occupation;
use App\Models\Referrer;
use App\Models\User;
use App\Models\Role;
use App\Models\State;
use App\Models\Topic;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Test;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


// Temporal Routes
Route::get('/', function () {
    // $books = Book::all();
    return view('welcome');
})->name('home');

Route::get('/fix',function(){
    $books = Book::all();
    $noExists = 0;
    $exists = 0;
    foreach ($books as $book) {
        if(Storage::exists("public/images/books/$book->title"))
        {
            Storage::rename("public/images/books/$book->title", "public/images/books/".$book->slug);

            $exists++;
        }else{
            $noExists++;
        }
    }
    
    return "Todos los libro tienen su carpeta con el nombre como slug -- Libros que no existian: $noExists y los que existian: $exists";
});

Route::get('fix2', function(){
    
    $books = Book::all();
    $reubi = 0;
    $noExists = 0;

    foreach ($books as $book) {
        if(Storage::exists("public/images/books/$book->title"))
        {
            Storage::move("public/images/books/$book->title", "public/content/books/".$book->slug);

            $reubi++;


        }
        elseif(Storage::exists("public/images/books/$book->slug"))
        {
            Storage::move("public/images/books/$book->slug", "public/content/books/".$book->slug);

            $reubi++;
        }
        else{
            $noExists++;
        }
    }


    return "Libro reubicados: $reubi  y no existen sus carpetas: $noExists";
});


Route::get('fix3', function(){

    $books = Book::all();
    $datesBook = [];

    foreach ($books as $book) {

        $datesBook['coverImage'] = Str::replaceFirst('images', 'content', $book->coverImage);
        
        ($book->backCoverImage) ? $datesBook['backCoverImage'] = Str::replaceFirst('images', 'content', $book->backCoverImage) : '';
        ($book->downloadable) ? $datesBook['downloadable'] = Str::replaceFirst('images', 'content', $book->downloadable) : '';
        ($book->audiobook) ? $datesBook['audiobook'] = Str::replaceFirst('images', 'content', $book->audiobook) : '';

        if($book->extraImages)
        {
            foreach ($book->extraImages as $extraImage) 
            {
                $extraImage->update([
                    'image' => Str::replaceFirst('images', 'content', $extraImage->image),
                ], ['timestamps' => false]); 
            }         
        }

        $book->update($datesBook, ['timestamps' => false]);
    }

    return 'Listo, todos los archivos están con sus nombre como el slug';
});

Route::get('fix4', function(){
    if(Storage::deleteDirectory('public/images')){
        return 'Directorio Images Eliminado';
    }else{
        return "Directorio \"Images\" No fue Eliminado";
    }
});

Route::get('counter', function(){
    
    $books = Book::all();
    $cant = $books->count();
    $b = 0;
    foreach ($books as $book) {
        
        (isset($book->counter)) ? $b++ : '' ;
    }
    return "De $cant Books, solo $b tiene contador de views";
});

// Route::get('storage-link', function(){
//     if(file_exists(public_path('storage')))
//     {
//         return 'Storage-Link ya estaba creado';
//     }

//     $this->laravel->nake('files')->link(
//         storage_path('app/public'), public_path('storage')
//     );

//     $this->info('El directorio [public/storage] ha sido linkeado');
// });

Route::get('/storage-link', function() {
    $exitCode = Artisan::call('storage:link');
    // Artisan::call('view:clear');
    return 'El directorio [public/storage] ha sido linkeado';
});

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('view:clear');
    return 'Cache y View Limpiada';
});

Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate');
    // Artisan::call('view:clear');
    dd($exitCode);
    return 'Migraciones creadas';
});

Route::get('crearCuentaDeProgramador', function () {

    if( !Role::firstWhere('name', 'Programador') or !User::firstWhere('email', 'javierjeanpieres@gmail.com'))
    {

        //Crear Idiomas
        Language::firstOrCreate(['name'=> 'Español']);
        Language::firstOrCreate(['name'=> 'Inglés']);
        Language::firstOrCreate(['name'=> 'Portugués']);
        Language::firstOrCreate(['name'=> 'Francés']);
        Language::firstOrCreate(['name'=> 'Italiano']);
        Language::firstOrCreate(['name'=> 'Alemán']);

        // Creación de los Roles
        Role::firstOrCreate(['name'=> 'Usuario'],[ 'visibility' => true]);
        Role::firstOrCreate(['name'=> 'Administrador'], ['visibility' => true]);
        Role::firstOrCreate(['name'=> 'Administrador Principal']);
        $roleProgrammer = Role::firstOrCreate(['name'=> 'Programador']);

        // Creación de los Genders
        Gender::firstOrCreate(['name'=> 'Mujer']);
        Gender::firstOrCreate(['name'=> 'Hombre']);
        $genderSinEspecificar = Gender::firstOrCreate(['name'=> 'Sin Especificar']);

        // Crear/buscar Country - State -City
        $argentina = Country::firstOrCreate(['name' => 'Argentina']);
        $buenosAiresProvince = State::firstOrCreate(['name' => 'Buenos Aires Province'], ['country_id' => $argentina->id, 'country_code' => 'AR', 'flag' => 1]);
        $escobar = City::Create(
                                ['name' => 'Escobar',
                                'state_id'=> $buenosAiresProvince->id,
                                // 'state_code'=> 'X', 
                                'country_id'=> $argentina->id, 
                                'country_code'=> 'AR', 
                                // 'latitude'=> '-31.67890000', 
                                // 'longitude'=> '-63.87964000', 
                                'created_at'=> now(), 
                                'updated_at'=> now(), 
                                // 'flag'=> 1, 
                                // 'wikiDataId'=> 'Q7193761'
                                ]);

        //Crear las diferentes Occupations
        $estudiante = Occupation::firstOrCreate(['name' => 'Estudiante']);
        Occupation::firstOrCreate(['name' => 'Consultor/a de EF']);
        Occupation::firstOrCreate(['name' => 'Empresa Familiar']);
        Occupation::firstOrCreate(['name' => 'Investigador/a']);
        Occupation::firstOrCreate(['name' => 'Profesional']);
        Occupation::firstOrCreate(['name' => 'Otros']);

        //Crear las ReferencedBy
        $iadef = Referrer::firstOrCreate(['name' => 'IADEF']);
        Referrer::firstOrCreate(['name' => 'ICOEF']);
        Referrer::firstOrCreate(['name' => 'AEFE']);
        Referrer::firstOrCreate(['name' => 'CEFE']);
        Referrer::firstOrCreate(['name' => 'IPEF']);
        Referrer::firstOrCreate(['name' => 'Buscador/Google']);
        Referrer::firstOrCreate(['name' => 'Redes Sociales']);
        Referrer::firstOrCreate(['name' => 'Otros']);

        User::create([
            'name' => 'Jepisan',
            'lastName' => 'Sanchez Cabrera',
            'gender_id' => $genderSinEspecificar->id,
            'role_id' => $roleProgrammer->id,
            'status' => true,
            'country_id' => $argentina->id,
            'state_id' => $buenosAiresProvince->id,
            'city_id' => $escobar->id,
            'phoneNumber' => +541158171254,
            'occupation_id' => $estudiante->id,
            'referrer_id' => $iadef->id,
            'email' => 'javierjeanpieres@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
        return redirect()->route('home');
    }
    else
    {
        return redirect()->route('home');
    }
});

Route::post('impersonate/{id}/start', function ($id) {
    $user = User::find($id);

    Auth::login($user);

    return redirect()->back();
})->name('impersonate.start')->middleware('auth');

Route::post('impersonate/{id}/stop', function ($id) {
    //Falta terminar
})->name('impersonate.stop')->middleware('auth');




Route::get('autores', function () {
    $topics = Author::all('name');

    return view('topics', compact('topics'));
})->name('autores');


Route::get('temas', function () {
    $topics = Topic::all('name');

    return view('topics', compact('topics'));
})->name('temas');



Route::get('temas/{id}', function ($id) {
    $topic = Topic::findOrFail($id);
    return $topic->name;
});

Route::get('creartemas', function(){
    $temas ='académica
    acción
    accionariado
    accionarial
    accionarias
    accionista
    accionistas
    Acontecimientos
    acquisition
    activa
    acuerdos
    acuerdos 
    Adicciones
    administración
    adquisiciones
    Afecto
    ajuste
    aliado
    Ámbitos
    ámbitos de comunicación
    antecesores
    aprendizaje
    arbitraje
    armonía
    Artículos
    asamblea 
    ascendientes
    asertiva
    Asesor
    Asesor
    asesoramiento
    Asesores
    asesoría
    autónomos
    Bancos
    beneficio
    biografía
    bisexuales
    boletos
    bolsa
    buen gobierno
    buena práctica 
    Cambios
    Camino
    canal
    capacitación
    capital económico
    capital financiero
    capital humano
    capital intangible
    capital intelectual
    capital riesgo
    capital social
    Capitán
    capitulaciones
    captación
    Carrera
    carta magna
    cátedras 
    CEFC
    certificación
    certificado
    ciclo vital 
    ciclos
    Civil
    cláusulas
    Coach
    Coaching
    código
    Código Civil 
    Cohesionada
    Comercialización
    comité
    compensación
    compra
    compraventas
    comunicación
    Comunicación
    Comunicacional
    conciliación
    Conciliar
    condiciones
    conflictos
    conflictos
    Consecuencias
    consejero
    Consejo de familia
    consejo 
    consorcio de primos
    constitución
    consultor
    consultora
    consultoría
    contenido
    contexto
    continuidad
    contratación
    contratos
    convención
    convenio
    convenios
    conyugales
    cónyuge
    Corporación
    corporativo
    cotización
    crecimiento
    Crecimiento
    crecimiento 
    creencias
    crisis
    Cultura
    De gerencia
    De primos
    De trabajo
    Debilidades
    definiciones
    Defunción
    Departamento
    dependencia
    Derecho
    Derecho Comercial
    derecho Familiar 
    derecho Laboral
    Derecho Tributario
    derechos y obligaciones
    desacuerdos
    descendientes
    Desconfianza
    Descripción de puestos
    Desigualdad
    despido
    Despidos
    Deudas
    dialogo
    diálogo
    Dificultades
    dinastía
    dirección
    director
    directores
    directorio
    Directorio
    disputas
    dividendo
    divorcio
    donación
    donación 
    Drogas
    due diligence
    duración
    Económica
    Ecosistema
    efectiva
    Efecto palanca
    emisor
    Emoción
    emociones
    Emperador
    empleabilidad
    empleada
    empleado
    empleo
    Empleo
    emprendedor
    Emprendedora
    emprendeduría 
    emprendimiento
    empresa de familia
    empresa de hermanos
    empresa de primos
    empresa familiar
    Empresa familiar
    Empresaria
    enajenación
    encuesta
    Entidades
    entrenador
    entrenadora
    Equipo
    equipo
    Equipo
    Errores
    escrita
    escuchar
    espacios de comunicación
    especialista
    espíritu emprendedor
    estatutario
    estatuto 
    estrategia
    estrategia
    Estrategias
    estratégias
    estructura
    etapas
    etapas
    Etapas
    etapas 
    ethos
    Éxito
    experta
    experto
    extramatrimonial
    Fallecimiento
    Fallecimiento
    familia
    Familia
    familia empresaria
    Familia empresaria
    familia 
    Familiar
    Familiares
    family office
    fideicomiso
    filantropía
    Financiación
    Financiero
    finanzas
    Fiscal
    Fiscales
    fondos 
    formación
    formación
    Formación de herederos
    formalidades
    foros de comunicación
    Fortalezas
    funciones
    fundación
    Fundaciones
    fundador
    fundadora
    fundadores
    fusiones
    ganancia
    garantía
    Gays
    generación
    Género
    Gerencia
    gerente
    gestión
    gestión de riesgo
    gestión financiera
    gobierno
    guerra familiar
    hablar
    Hechos
    herencia
    herramientas
    Hijos
    historia
    holding
    homosexuales
    i+d+i
    Igualdad
    Impositivo
    impuesto
    incorporación
    índices
    Información
    informar
    Ingreso
    Innovación
    instrucción
    inteligencia emocional
    inter vivos
    intergeneracional
    Internacionalización
    intersexuales
    Investigación
    investigación y desarrollo
    iteración
    iterar
    jefe
    jóvenes
    Laboral
    legado
    Legal
    legar
    legítima
    lenguaje
    lesbianas
    Ley
    LGBTI
    Líder
    Liderazgo
    Liderazgo
    liquidez
    longevidad
    M&A
    Maestro
    management 
    Manejo
    manifiesto 
    manual
    marca
    Marketing
    Maternofiliales
    Matrimonio
    matrimonio
    mayores
    mecenazgo
    mediación
    Mejora continua
    mensaje
    mentor
    Mentoring
    mercadotecnia
    mercantil
    merger
    Método
    Metodología
    métodos
    miembros
    Misión
    Misión
    modelos
    modelos conceptuales
    mortis causa
    Muerte
    Mujer
    Mujer empresaria
    narración
    negociación
    negocio familiar
    nepotismo
    next generation
    normas
    nueva generación
    Objetivos
    Objetivos de desarrollo sostenible
    Obligaciones
    observatorio
    ODS
    oficina familiar
    oral
    Organigrama
    Organización
    órgano
    órganos de gobierno
    pacto
    Pactos
    pactos de sindicación
    padres
    Padres
    parejas de hecho
    Parientes
    Participación
    participaciones
    Paternofiliales
    patrimonial
    patrimonio
    pautas
    Pautas para trabajo en equipo
    Pecados
    pelea
    pérdida
    persona
    personal
    pertenencia
    plan de carrera
    planificación
    planificación estratégica
    Planteo
    Plazos
    Política
    Política Familiares
    políticas
    políticas
    Políticos
    Políticos
    Posibilidades
    prácticas
    predecesores
    prensa
    prenupciales
    presidente
    primera generación
    problemas
    procedimientos
    procesos
    profesional
    profesionalización
    Profesionalización
    progenitores
    propietaria
    propietario
    Propósito
    protocolo
    protocolo
    proyección
    pugnas familiares
    quiebra
    radio
    receptor
    recursos humanos
    Red
    Redes
    regla
    Reglamentación
    Reglamentos
    Relacional
    relevo
    remuneración
    renta
    rentabilidad
    Rentabilidad
    reparto
    reputación corporativa
    research
    Respeto
    Responsabilidad Social Corporativa
    responsabilidad social empresaria
    responsabilidades
    resultado 
    retención
    retiro
    reuniones
    Riesgos
    riqueza
    rol
    RRHH
    RSC
    RSE
    salarial
    salario
    salida
    segunda generación
    Seguros
    selección
    Semblanza
    sentimientos 
    separación
    SGR 
    siguiente generación
    Sistema
    sistemas
    sistemas de comunicación
    socia
    Sociedad
    sociedad
    societaria
    societario
    socio
    Soluciones
    sostenibilidad
    sucedido
    Sucesión
    sucesión 
    sucesor
    Sucesores
    sueldo
    Superación
    sustentabilidad
    Táctica
    talento
    Techo de cristal 
    televisión
    Terapia familiar sistémica
    tercera generación
    testamentaria
    testamento
    tipo 
    tipos de empresas familiares
    titular
    titularidad
    tono
    Trabajo
    tradición
    transexuales
    transmisión
    transmisión de la propiedad
    traspaso
    trazabilidad
    tributario
    tributo
    trust
    Tutor
    usufructo
    valoración
    Valores
    valores 
    valuación
    Venta
    Ventas
    Vida
    vida
    violenta
    Visión
    visual';
    
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('topics')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    
            
        function first($cadena) {
    
            $cadena = trim($cadena);
            // salida
            $out = '';
            // obtenemos la longitud
            $len = mb_strlen($cadena, 'UTF-8');
            // cadena en minúsculas
            $min = mb_convert_case($cadena,  MB_CASE_LOWER);
            // cadena en mayúsculas
            $mas = mb_convert_case($cadena,  MB_CASE_UPPER);
        
            //comparamos carácter a carácter
            for($i = 0; $i < $len; $i++) {
                // si son iguales añadimos a la salida y continuamos
                if(mb_substr($min, $i, 1, 'UTF-8')==mb_substr($mas, $i, 1, 'UTF-8')){
                    $out .= mb_substr($cadena, $i, 1, 'UTF-8');
                    continue;
                }
                // si no son iguales extraemos el carácter en mayúscula
                $out .= mb_substr($mas, $i, 1, 'UTF-8');
                // extraemos el resto de la cadena
                $out .= mb_substr($cadena, $i+1, NULL, 'UTF-8');
                // salimos del bucle
                break;
            }
                return $out;
            
        };
            
    $temas = explode("\r\n", $temas);
            $temas = array_map('first', $temas);
    
            foreach ($temas as $tema) {
                
                Topic::firstOrCreate([
                    'name' => $tema
                ]);
            }

    return redirect()->route('temas');
})->name('creartemas');
