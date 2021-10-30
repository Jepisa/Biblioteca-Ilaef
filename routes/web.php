<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Content\BookController;
use App\Http\Controllers\Content\PodcastController;
use App\Http\Controllers\Content\EbookController;
use App\Http\Controllers\Content\InvestigationWorkController;
use App\Http\Controllers\SearchContentController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/auth.php';
require __DIR__.'/programmer.php';
require __DIR__.'/admin.php';



Route::get('/', HomeController::class)->name('home')->middleware('auth');


Route::get('favorites', function () {
    return view('favorites');
})->middleware(['verified','auth'])->name('favorites');

Route::get('profile', function () {
    return view('profile');
})->middleware(['verified', 'auth'])->name('profile');

Route::get('changePassword', function () {
    return view('changePassword');
})->middleware(['verified', 'auth'])->name('changePassword');

Route::get('aboutUs', function () {
    return view('aboutUs');
})->middleware(['verified','auth'])->name('aboutUs');
Route::get('contact', function () {
    return view('contact');
})->middleware(['verified','auth'])->name('contact');

Route::get('search', [SearchContentController::class, 'search'])->name('searchContent');

//Books

Route::get('book/{slug}', [BookController::class, 'show'])->name('book.show');

//Podcast
Route::get('podcasts', [PodcastController::class, 'index'])->name('podcasts.index')->middleware('auth');
Route::get('podcast/create', [PodcastController::class, 'create'])->name('podcast.create')->middleware(['auth']);
Route::get('podcast/{slug}', [PodcastController::class, 'show'])->name('podcast.show');
Route::post('podcast',[PodcastController::class, 'store'])->name('podcast.store')->middleware('auth');
Route::get('podcast/{slug}/edit', [PodcastController::class, 'edit'])->name('podcast.edit');
Route::put('podcast/{slug}', [PodcastController::class, 'update'])->name('podcast.update');
Route::delete('podcast/{slug}', [PodcastController::class, 'destroy'])->name('podcast.destroy');

//E-Books
Route::get('ebooks', [EbookController::class, 'index'])->name('ebooks.index')->middleware('auth');
Route::get('ebook/create', [EbookController::class, 'create'])->name('ebook.create')->middleware(['auth']);
Route::get('ebook/{slug}', [EbookController::class, 'show'])->name('ebook.show');
Route::post('ebook',[EbookController::class, 'store'])->name('ebook.store')->middleware('auth');
Route::get('ebook/{slug}/edit', [EbookController::class, 'edit'])->name('ebook.edit');
Route::put('ebook/{slug}', [EbookController::class, 'update'])->name('ebook.update');
Route::delete('ebook/{slug}', [EbookController::class, 'destroy'])->name('ebook.destroy');

//Investigation Work
Route::get('investigation-works', [InvestigationWorkController::class, 'index'])->name('investigationworks.index')->middleware('auth');
Route::get('investigation-work/create', [InvestigationWorkController::class, 'create'])->name('investigationwork.create')->middleware(['auth']);
Route::get('investigation-work/{slug}', [InvestigationWorkController::class, 'show'])->name('investigation-work.show');
Route::post('investigation-work',[InvestigationWorkController::class, 'store'])->name('investigationwork.store')->middleware('auth');
Route::get('investigation-work/{slug}/edit', [InvestigationWorkController::class, 'edit'])->name('investigationwork.edit');
Route::put('investigation-work/{slug}', [InvestigationWorkController::class, 'update'])->name('investigationwork.update');
Route::delete('investigation-work/{slug}', [InvestigationWorkController::class, 'destroy'])->name('investigationwork.destroy');




Route::get('author/create', [AuthorController::class, 'create'])->name('author.create');
Route::post('author', [AuthorController::class, 'store'])->name('authore.store');
Route::get('author/{name}/edit', [AuthorController::class, 'edit'])->name('author.edit');
Route::put('author{name}', [AuthorController::class, 'update'])->name('author.update');
Route::delete('author{name}', [AuthorController::class, 'destroy'])->name('author.destroy');



Route::view('results', 'results')->name('results');
Route::view('max-results', 'max-results');

Route::get('max-search', [SearchContentController::class, 'search'])->name('max-search');

Route::get('testdb', function(){
    DB::statement("CREATE OR REPLACE
    ALGORITHM = UNDEFINED VIEW `ilaeforg_biblioteca_test`.`content_list` AS
    select
        'book' AS `type`,
        `b`.`title` AS `title`,
        `b`.`slug` AS `slug`,
        `b`.`coverImage` AS `coverImage`,
        `b`.`editorial` AS `editorial`,
        `b`.`isbn` AS `isbn`,
        `b`.`year` AS `year`,
        `c`.`views` AS `views`,
        `authors`.`authors` AS `authors`,
        `topics`.`topics` AS `topics`
    from
        ((((
        select
            `b`.`id` AS `id`,
            concat(group_concat(`a2`.`name` separator ','), '.') AS `authors`
        from
            ((`ilaeforg_biblioteca_test`.`books` `b`
        join `ilaeforg_biblioteca_test`.`authorables` `a` on
            (((`a`.`authorable_id` = `b`.`id`)
                and (`a`.`authorable_type` = 'App\\Models\\Book'))))
        join `ilaeforg_biblioteca_test`.`authors` `a2` on
            ((`a`.`author_id` = `a2`.`id`)))
        group by
            `b`.`id`) `authors`
    join (
        select
            `b`.`id` AS `id`,
            concat(group_concat(`t2`.`name` separator ','), '.') AS `topics`
        from
            ((`ilaeforg_biblioteca_test`.`books` `b`
        join `ilaeforg_biblioteca_test`.`topicables` `t` on
            (((`t`.`topicable_id` = `b`.`id`)
                and (`t`.`topicable_type` = 'App\\Models\\Book'))))
        join `ilaeforg_biblioteca_test`.`topics` `t2` on
            ((`t`.`topic_id` = `t2`.`id`)))
        group by
            `b`.`id`) `topics`)
    join `ilaeforg_biblioteca_test`.`books` `b`)
    join `ilaeforg_biblioteca_test`.`counters` `c`)
    where
        ((`b`.`id` = `authors`.`id`)
            and (`b`.`id` = `topics`.`id`)
                and (`b`.`id` = `c`.`countable_id`)
                    and (`c`.`countable_type` = 'App\\Models\\Book'))
    union all
    select
        'ebook' AS `type`,
        `eb`.`title` AS `title`,
        `eb`.`slug` AS `slug`,
        `eb`.`coverImage` AS `coverImage`,
        `eb`.`editorial` AS `editorial`,
        `eb`.`isbn` AS `isbn`,
        `eb`.`year` AS `year`,
        `c`.`views` AS `views`,
        `authors`.`authors` AS `authors`,
        `topics`.`topics` AS `topics`
    from
        ((((
        select
            `eb`.`id` AS `id`,
            concat(group_concat(`a2`.`name` separator ','), '.') AS `authors`
        from
            ((`ilaeforg_biblioteca_test`.`ebooks` `eb`
        join `ilaeforg_biblioteca_test`.`authorables` `a` on
            (((`a`.`authorable_id` = `eb`.`id`)
                and (`a`.`authorable_type` = 'App\\Models\\Ebook'))))
        join `ilaeforg_biblioteca_test`.`authors` `a2` on
            ((`a`.`author_id` = `a2`.`id`)))
        group by
            `eb`.`id`) `authors`
    join (
        select
            `eb`.`id` AS `id`,
            concat(group_concat(`t2`.`name` separator ','), '.') AS `topics`
        from
            ((`ilaeforg_biblioteca_test`.`ebooks` `eb`
        join `ilaeforg_biblioteca_test`.`topicables` `t` on
            (((`t`.`topicable_id` = `eb`.`id`)
                and (`t`.`topicable_type` = 'App\\Models\\Ebook'))))
        join `ilaeforg_biblioteca_test`.`topics` `t2` on
            ((`t`.`topic_id` = `t2`.`id`)))
        group by
            `eb`.`id`) `topics`)
    join `ilaeforg_biblioteca_test`.`ebooks` `eb`)
    join `ilaeforg_biblioteca_test`.`counters` `c`)
    where
        ((`eb`.`id` = `authors`.`id`)
            and (`eb`.`id` = `topics`.`id`)
                and (`eb`.`id` = `c`.`countable_id`)
                    and (`c`.`countable_type` = 'App\\Models\\Ebook'))
    union all
    select
        'investigation-work' AS `type`,
        `iw`.`title` AS `title`,
        `iw`.`slug` AS `slug`,
        `iw`.`coverImage` AS `coverImage`,
        NULL AS `editorial`,
        `iw`.`isbn` AS `isbn`,
        `iw`.`year` AS `year`,
        `c`.`views` AS `views`,
        `authors`.`authors` AS `authors`,
        `topics`.`topics` AS `topics`
    from
        ((((
        select
            `iw`.`id` AS `id`,
            concat(group_concat(`a2`.`name` separator ','), '.') AS `authors`
        from
            ((`ilaeforg_biblioteca_test`.`investigation_works` `iw`
        join `ilaeforg_biblioteca_test`.`authorables` `a` on
            (((`a`.`authorable_id` = `iw`.`id`)
                and (`a`.`authorable_type` = 'App\\Models\\InvestigationWork'))))
        join `ilaeforg_biblioteca_test`.`authors` `a2` on
            ((`a`.`author_id` = `a2`.`id`)))
        group by
            `iw`.`id`) `authors`
    join (
        select
            `iw`.`id` AS `id`,
            concat(group_concat(`t2`.`name` separator ','), '.') AS `topics`
        from
            ((`ilaeforg_biblioteca_test`.`investigation_works` `iw`
        join `ilaeforg_biblioteca_test`.`topicables` `t` on
            (((`t`.`topicable_id` = `iw`.`id`)
                and (`t`.`topicable_type` = 'App\\Models\\InvestigationWork'))))
        join `ilaeforg_biblioteca_test`.`topics` `t2` on
            ((`t`.`topic_id` = `t2`.`id`)))
        group by
            `iw`.`id`) `topics`)
    join `ilaeforg_biblioteca_test`.`investigation_works` `iw`)
    join `ilaeforg_biblioteca_test`.`counters` `c`)
    where
        ((`iw`.`id` = `authors`.`id`)
            and (`iw`.`id` = `topics`.`id`)
                and (`iw`.`id` = `c`.`countable_id`)
                    and (`c`.`countable_type` = 'App\\Models\\InvestigationWork'))");
                    
                    
    return 'VIEW creado';
});