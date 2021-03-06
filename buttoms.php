<?php
    /* defining the game numbers. these can be changed for diferent games */
    $MAXNUMBER = 10; // the count of the questions.

    // answer 1
    // $option = array(array("salam", "Key1"), array("key2", "key3"), array("شروع"));
    // $replyMarkup = array(
    //     'keyboard' => $option,
    //     'one_time_keyboard' => false,
    //     'resize_keyboard' => true,
    //     'selective' => true
    // );
    // $encodedMarkup = json_encode($replyMarkup, true);

    /* the exam's questions */
    $questions = array(
        "۱) چه موقع از روز بهترین و آرام ترین احساس را دارید؟",
        "۲) معمولاً چگونه راه مى روید؟",
        "۳) وقتى با دیگران صحبت مى کنید؛",
        "۴) وقتى آرام هستید، چگونه مى نشینید؟",
        "۵) وقتى چیزى واقعاً براى شما جالب است، چگونه واکنش نشان مى دهید؟",
        "۶) وقتى وارد یک میهمانى یا جمع مى شوید؛",
        "۷) سخت مشغول کارى هستید، بر آن تمرکز دارید، اما ناگهان دلیلى یا شخصى آن را قطع مى کند؛",
        "۸) کدامیک از مجموعه رنگ هاى زیر را بیشتر دوست دارید؟",
        "۹) وقتى در رختخواب هستید (در شب) در آخرین لحظات پیش از خواب، در چه حالتى دراز مى کشید؟",
        "۱۰) آیا شما غالباً خواب مى بینید که:",
        "جواب تست:تست روانشناسی شخصیت جدید"
    );

    /* the exam's questions' choises */
    $choises = array(
        /* 1 */array("صبح", "عصر و غروب", "شب"),
        /* 2 */array("نسبتاً سریع، با قدم هاى بلند،", "نسبتاً سریع، با قدمهاى کوتاه ولى تند و پشت سر هم", "آهسته تر، با سرى صاف روبرو", "آهسته و سربه زیر", "خیلى آهسته"),
        /* 3 */array("مى ایستید و دست به سینه حرف مى زنید", "دستها را در هم قلاب مى کنید", "یک یا هر دو دست را در پهلو مى گذارید", "دست به شخصى که با او صحبت مى کنید، مى زنید", "با گوش خود بازى مى کنید، به چانه تان دست مى زنید یا موهایتان را صاف مى کنید"),
        /* 4 */array("زانوها خم و پاها تقریباً کنار هم", "چهارزانو", "پاى صاف و دراز به بیرون", "یک پا زیر دیگرى خم"),
        /* 5 */array("خنده اى بلند که نشان دهد چقدر موضوع جالب بوده", "خنده، اما نه بلند", "با پوزخند کوچک", "لبخند بزرگ", "لبخند کوچک"),
        /* 6 */array("با صداى بلند سلام و حرکتى که همه متوجه شما شوند، وارد مى شوید", "با صداى آرامتر سلام مى کنید و سریع به دنبال شخصى که مى شناسید، مى گردید", "در حد امکان آرام وارد مى شوید، سعى مى کنید به نظر سایرین نیایید"),
        /* 7 */array("از وقفه ایجاد شده راضى هستید و از آن استقبال مى کنید", "بسختى ناراحت مى شوید", "حالتى بینابین این ۲ حالت ایجاد مى شود"),
        /* 8 */array("قرمز یا نارنجى", "سیاه", "زرد یا آبى کمرنگ", "سبز", "آبى تیره یا ارغوانى", "سفید", "قهوه اى، خاکسترى، بنفش"),
        /* 9 */array("به پشت", "روى شکم (دمر)", "به پهلو و کمى خم و دایره اى", "سر بر روى یک دست", "سر زیر پتو یا ملافه..."),
        /* 10*/array("از جایى مى افتید.", "مشغول جنگ و دعوا هستید.", "به دنبال کسى یا چیزى هستید.", "پرواز مى کنید یا در آب غوطه ورید.", "اصلاً خواب نمى بینید.", "معمولاً خواب هاى خوش مى بینید.")
    );

    /* the exam's questions' choises' marks */
    $marks = array(
        /* 1 */array("2", "4", "6"),                      //  1
        /* 2 */array("6", "4", "7", "2", "1"),            //  2
        /* 3 */array("4", "2", "5", "7", "6"),            //  3
        /* 4 */array("4", "6", "2", "1"),                 //  4
        /* 5 */array("6", "4", "3", "5", "2"),            //  5
        /* 6 */array("6", "4", "2"),                      //  6
        /* 7 */array("6", "2", "4"),                      //  7
        /* 8 */array("6", "7", "5", "4", "3", "2", "1"),  //  8
        /* 9 */array("7", "6", "4", "2", "1"),            //  9
        /* 10*/array("4", "2", "3", "5", "6", "1")        // 10
    );

    /* buttoms created from the questions' choises array */
    $buttoms = array(
        /* 1 */array(array('صبح'), array('عصر و غروب', 'شب')),
        /* 2 */array(array('نسبتاً سریع، با قدم هاى بلند،'), array('نسبتاً سریع، با قدمهاى کوتاه ولى تند و پشت سر هم'), array('آهسته تر، با سرى صاف روبرو'), array('آهسته و سربه زیر', 'خیلى آهسته')),
        /* 3 */array(array('مى ایستید و دست به سینه حرف مى زنید'), array('دستها را در هم قلاب مى کنید'), array('یک یا هر دو دست را در پهلو مى گذارید'), array('دست به شخصى که با او صحبت مى کنید، مى زنید'), array('با گوش خود بازى مى کنید، به چانه تان دست مى زنید یا موهایتان را صاف مى کنید')),
        /* 4 */array(array('زانوها خم و پاها تقریباً کنار هم'), array('چهارزانو', 'پاى صاف و دراز به بیرون'), array('یک پا زیر دیگرى خم')),
        /* 5 */array(array('خنده اى بلند که نشان دهد چقدر موضوع جالب بوده'), array('خنده، اما نه بلند', 'با پوزخند کوچک'), array('لبخند بزرگ', 'لبخند کوچک')),
        /* 6 */array(array('با صداى بلند سلام و حرکتى که همه متوجه شما شوند، وارد مى شوید'), array('با صداى آرامتر سلام مى کنید و سریع به دنبال شخصى که مى شناسید، مى گردید'), array('در حد امکان آرام وارد مى شوید، سعى مى کنید به نظر سایرین نیایید')),
        /* 7 */array(array('از وقفه ایجاد شده راضى هستید و از آن استقبال مى کنید'), array('بسختى ناراحت مى شوید'), array('حالتى بینابین این ۲ حالت ایجاد مى شود')),
        /* 8 */array(array('قرمز یا نارنجى', 'سیاه'), array('زرد یا آبى کمرنگ', 'سبز', 'آبى تیره یا ارغوانى'), array('سفید', 'قهوه اى، خاکسترى، بنفش')),
        /* 9 */array(array('به پشت', 'روى شکم (دمر)'), array('به پهلو و کمى خم و دایره اى'), array('سر بر روى یک دست', 'سر زیر پتو یا ملافه...')),
        /* 10*/array(array('از جایى مى افتید.', 'مشغول جنگ و دعوا هستید.'), array('به دنبال کسى یا چیزى هستید.', 'پرواز مى کنید یا در آب غوطه ورید.'), array('اصلاً خواب نمى بینید.', 'معمولاً خواب هاى خوش مى بینید.')),
    );

    $characters = array(
        /*   -21 *//* 1 */ 0 => "دیگران شما را خجالتى، عصبى و آدمى شکاک و دودل مى دانند شخصى که همیشه سایرین به عوض او فکر مى کنند، برایش تصمیم مى گیرند و از او مراقبت مى کنند. کسى که اصلاً تمایل به درگیرشدن در کارهاى گروهى و ارتباط با افراد دیگر را ندارد.",
        /* 21-30 *//* 2 */21 => "در نظر سایرین فردى زحمت کش هستید اما متأسفانه گاهى اوقات ایرادگیر هستید. شما بسیار بسیار محتاط و بى نهایت ملاحظه کار به نظر مى رسید. زحمتکشى که در کمال آرامش و با صرف زمان زیاد در جمع بار دیگران را بردوش مى کشد و بدون فکر و براساس تحریک لحظه اى و آنى هرگز نظر نمى دهد. دیگران مى دانند شما همیشه تمام جوانب کارها را مى سنجید و سپس تصمیم مى گیرید.",
        /* 31-40 *//* 3 */31 => "بدانید در نظر سایرین معقول، هوشیار، دقیق ، ملاحظه کار و اهل عمل هستید. همه مى دانند شما باهوش و با استعداد هستید اما مهمتر از همه فروتن و متواضع هستید. به سرعت و سادگى با دیگران باب دوستى را باز نمى کنید. اما اگر با کسى دوست شوید صادق، باوفا و وظیفه شناس هستید. اما انتظار بازگشت این صداقت و صمیمیت از طرف دوستانتان را دارید گرچه سخت دوست مى شوید اما سخت تر دوستى ها را رها مى کنید.",
        /* 41-50 *//* 4 */41 => "به خود امیدوار باشید ، دیگران شما را بانشاط، سرزنده، سرگرم کننده و جالب و جذاب مى بینند. شما دائماً مرکز توجه جمع هستید و از تعادل رفتارى خوبى بهره مند هستید. فردى مهربان، ملاحظه کار و فهمیده به نظر مى رسید. قادر هستید به موقع باعث شادى و خوشى دوستانتان شوید و اسباب هلهله و خنده آنها را فراهم کنید و در همان شرایط و در صورت لزوم بهترین کمک بر اعضاى گروه هستید.",
        /* 51-60 *//* 5 */51 => "بدانید دوستان شما را تحریک پذیر مى دانند، بدون فکر عمل مى کنیدو سریع از موضوعات ناخوشایند برآشفته مى شوید ، علاقه مند به رهبرى جمع و تصمیم گیریهاى سریع دارید (هرچند اغلب درست از کار درنمى آیند!) دیگران شما را جسور و اهل مخاطره مى دانند. کسى که همه چیز را تجربه و امتحان مى کند، از ماجراجویى لذت مى برد و در مجموع به دلیل ایجاد شرایط و بستر هیجانات توسط شما، از همراهى تان لذت مى برند.",
        /* 61-   *//* 6 */61 => "دیگران در ارتباط و رفتار با شما شدیداً مراقب و هوشیار هستند آنها شما را مغرور، خودمحور و بى نهایت سلطه جو مى دانند، گرچه شما را تحسین مى کنند و به ظاهر مى گویندکاش من جاى تو بودم!! اما معمولاً به شما اعتماد ندارند و نسبت به ایجاد رابطه اى عمیق و دوستانه بى میل و فرارى هستند."
    );

    $btns = array(
        "invite" => array(array("لینک دعوت نامه"))
    );

    $btn_finishedExam = array(array("امتیاز من","دعوت دیگران", "شخصیت من"), array("چند نفر را دعوت کرده ام؟"));