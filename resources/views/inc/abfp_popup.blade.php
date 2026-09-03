@php
    // Легка версія popup-перегляду особистого фото (аналог inc/abf_popup.blade.php, але для
    // таблиці Fotop). Коментарі підвантажуються асинхронно через /abfp_comments після показу фото.
    $M5 = $Namef;

    $monm = substr($M6, 5, 2);
    $yem = substr($M6, 0, 4);
    $monmf = ((int) $monm < 10) ? substr($M6, 6, 1) : $monm;
    if ((int) $yem <= 2007) {
        $yem = "2005-2007";
        $monmf = "";
    }

    // "b"-префікс — версія великої якості, пріоритет їй (як на сторінці /nf, див. fi.blade.php)
    $katalogBig = "Fotop/$yem$monmf/b$M5.$M7";
    $katalogRegular = "Fotop/$yem$monmf/$M5.$M7";
    $katalogface = getKatalogface($katalogBig, $katalogRegular);

    $authorLink = null;
    if ($avt > 10 && $avt != $id) {
        $page = last_visit_read($avt);
        if ($page) {
            $pref_page_i = __('messages.pref_page') . 'i';
            $authorLink = ['url' => "/$pref_page_i$avt", 'name' => trim($page['im'] . ' ' . $page['priz'])];
        }
    }

    $M6_e = db_date($M6);

    if (Auth::user()) {
        $Numm = Auth::user()->id;
    } else {
        $Numm = "0000000000";
    }
    if (!$r_gol) {
        $r_kol = 0;
    }
    // Поки ніхто не оцінив фото — зірка напівпрозора/притлумлена, після першої оцінки "запалюється"
    // кольором (синій → золотий → оранжевий за кількістю оцінок).
    $color_star = "rgba(255,255,255,0.55)";
    if ($r_kol > 0) { $color_star = "#356AA0"; }
    if ($r_kol > 1) { $color_star = "gold"; }
    if ($r_kol > 4) { $color_star = "orange"; }
    $rect = "shine";
    if (mb_strstr("$rh", "$Numm") != "") {
        $rect = "";
    }

    $fpref_page = __('messages.pref_page') . 'ni';
@endphp
<div class="popup-photo">
    <div class="popup-photo-frame">
        <a href="##" class="popup-close" aria-label="{{__('messages.Close')}}" onclick="shut_abf(); return false;">&times;</a>
        <img class="popup-photo-img" loading="eager" src="{{ $katalogface }}" alt="{{ $alb }}">
        <div id="d{{ $M5 }}" class="popup-like">
            <svg class="star-container popup-like-star" width="22" height="22" onclick="rate_addp('d{{ $M5 }}',{{ $M5 }},'popup')" rel="noopener noreferrer">
                <use class="star" fill="{{ $color_star }}" href="/images/icons.svg#icon-star-full"></use>
                <rect class="{{ $rect }}" fill="white"></rect>
            </svg>
            <a href="##" class="popup-like-count" onclick="rate_hp('r{{ $M5 }}',{{ $M5 }})" rel="noopener noreferrer">{{ $r_kol }}</a>
        </div>
    </div>
    <div class="popup-photo-meta">
        <div class="popup-photo-place">{{ $alb }}</div>
        <div class="popup-photo-sub">
            <span>{{ $M6_e }}</span>
            @if($authorLink)<span>{{ __('messages.avtor') }}: <a href="{{ $authorLink['url'] }}">{{ $authorLink['name'] }}</a></span>@endif
        </div>
        <ul class="fmenu popup-photo-fmenu">
            <li id="fv{{ $M5 }}" class="fview">
                <svg title="{{ __('messages.views') }}" width="18" height="18"><use href="/images/icons.svg#icon-magnifying-glass"></use></svg>
                {{ $views }}
            </li>
        </ul>
        <div class="centeredm" id="r{{ $M5 }}"></div>

        <div id="in{{ $M5 }}" class="popup-comments">
            <p class="popup-comments-loading">{{ __('messages.popup_comments_loading') }}</p>
        </div>
        @auth
            {{-- Поле вводу приховане, поки асинхронно (comm_allowp) не підтвердиться дозвіл --}}
            <div id="cg{{ $M5 }}" class="comm-allowp-gate un-display" data-namef="{{ $M5 }}">
                <textarea id="cm{{ $M5 }}" rows="2" class="popup-comment-input" placeholder="{{ __('messages.comment_in') }}" onfocus="clearsp('cm{{ $M5 }}','bc{{ $M5 }}');"></textarea>
                <div id="bc{{ $M5 }}" class="un-display centeredm">
                    <table><tr><td class="fcomblue intop com-button">
                        <a onclick="comm_addp({{ $M5 }},'cm{{ $M5 }}','in{{ $M5 }}')">{{ __('messages.Add') }}</a>
                    </td></tr></table>
                </div>
            </div>
        @endauth

        <a class="popup-photo-more" href="/{{ $fpref_page }}{{ $M5 }}">{{ __('messages.popup_open_full') }} →</a>
    </div>
</div>
