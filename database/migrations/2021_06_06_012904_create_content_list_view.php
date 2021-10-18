<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentListView extends Migration
{
    
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->createView());
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView(): string
    {
        return <<

        CREATE OR REPLACE
        ALGORITHM = UNDEFINED VIEW `biblioteca_ilaef`.`content_list` AS
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
                ((`biblioteca_ilaef`.`books` `b`
            join `biblioteca_ilaef`.`authorables` `a` on
                (((`a`.`authorable_id` = `b`.`id`)
                    and (`a`.`authorable_type` = 'App\\Models\\Book'))))
            join `biblioteca_ilaef`.`authors` `a2` on
                ((`a`.`author_id` = `a2`.`id`)))
            group by
                `b`.`id`) `authors`
        join (
            select
                `b`.`id` AS `id`,
                concat(group_concat(`t2`.`name` separator ','), '.') AS `topics`
            from
                ((`biblioteca_ilaef`.`books` `b`
            join `biblioteca_ilaef`.`topicables` `t` on
                (((`t`.`topicable_id` = `b`.`id`)
                    and (`t`.`topicable_type` = 'App\\Models\\Book'))))
            join `biblioteca_ilaef`.`topics` `t2` on
                ((`t`.`topic_id` = `t2`.`id`)))
            group by
                `b`.`id`) `topics`)
        join `biblioteca_ilaef`.`books` `b`)
        join `biblioteca_ilaef`.`counters` `c`)
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
                ((`biblioteca_ilaef`.`ebooks` `eb`
            join `biblioteca_ilaef`.`authorables` `a` on
                (((`a`.`authorable_id` = `eb`.`id`)
                    and (`a`.`authorable_type` = 'App\\Models\\Ebook'))))
            join `biblioteca_ilaef`.`authors` `a2` on
                ((`a`.`author_id` = `a2`.`id`)))
            group by
                `eb`.`id`) `authors`
        join (
            select
                `eb`.`id` AS `id`,
                concat(group_concat(`t2`.`name` separator ','), '.') AS `topics`
            from
                ((`biblioteca_ilaef`.`ebooks` `eb`
            join `biblioteca_ilaef`.`topicables` `t` on
                (((`t`.`topicable_id` = `eb`.`id`)
                    and (`t`.`topicable_type` = 'App\\Models\\Ebook'))))
            join `biblioteca_ilaef`.`topics` `t2` on
                ((`t`.`topic_id` = `t2`.`id`)))
            group by
                `eb`.`id`) `topics`)
        join `biblioteca_ilaef`.`ebooks` `eb`)
        join `biblioteca_ilaef`.`counters` `c`)
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
                ((`biblioteca_ilaef`.`investigation_works` `iw`
            join `biblioteca_ilaef`.`authorables` `a` on
                (((`a`.`authorable_id` = `iw`.`id`)
                    and (`a`.`authorable_type` = 'App\\Models\\InvestigationWork'))))
            join `biblioteca_ilaef`.`authors` `a2` on
                ((`a`.`author_id` = `a2`.`id`)))
            group by
                `iw`.`id`) `authors`
        join (
            select
                `iw`.`id` AS `id`,
                concat(group_concat(`t2`.`name` separator ','), '.') AS `topics`
            from
                ((`biblioteca_ilaef`.`investigation_works` `iw`
            join `biblioteca_ilaef`.`topicables` `t` on
                (((`t`.`topicable_id` = `iw`.`id`)
                    and (`t`.`topicable_type` = 'App\\Models\\InvestigationWork'))))
            join `biblioteca_ilaef`.`topics` `t2` on
                ((`t`.`topic_id` = `t2`.`id`)))
            group by
                `iw`.`id`) `topics`)
        join `biblioteca_ilaef`.`investigation_works` `iw`)
        join `biblioteca_ilaef`.`counters` `c`)
        where
            ((`iw`.`id` = `authors`.`id`)
                and (`iw`.`id` = `topics`.`id`)
                    and (`iw`.`id` = `c`.`countable_id`)
                        and (`c`.`countable_type` = 'App\\Models\\InvestigationWork'))
            SQL;
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return <<

            DROP VIEW IF EXISTS `view_user_data`;
            SQL;
    }

}
