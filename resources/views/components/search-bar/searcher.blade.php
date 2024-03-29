<div
    class="color_azuloscuro background_rojooscuro w-full block md:flex items-center p-3 rounded-lg searchBar_container relative z-50 text_responsive">
    {{-- <div class="flex items-center justify-center w-full"> --}}
        <form class="flex items-center justify-center w-full" action="{{ route('max-search') }}" method="get">
            <div class="block">
                <select name="searchType" id="content-select" autocomplete="off" class="text_responsive w-24">
                    <option value="all" @if(isset($_GET["searchType"]) && $_GET["searchType"] == 'all') selected @endif>Todo</option>
                    <option value="authors" @if(isset($_GET["searchType"]) && $_GET["searchType"] == 'authors') selected @endif>Autor</option>
                    <option value="title" @if(isset($_GET["searchType"]) && $_GET["searchType"] == 'title') selected @endif>Título</option>
                    <option value="editorial" @if(isset($_GET["searchType"]) && $_GET["searchType"] == 'editorial') selected @endif>Editorial</option>
                    <option value="topics" @if(isset($_GET["searchType"]) && $_GET["searchType"] == 'topics') selected @endif>Tema</option>
                    <option value="isbn" @if(isset($_GET["searchType"]) && $_GET["searchType"] == 'isbn') selected @endif>ISBN</option>
                </select>
            </div>
            <div class="input_search_mainContainer text_responsive cursor-pointer ml-4 mr-0 md:mr-4">
                <button type='submit' class="w-4 h-4 absolute z-50 left-6 top-5 md:left-28 lg:left-32 2xl:left-36 md:top-5 magnifier_icon">
                    <i class="fas fa-search"></i>
                </button>
                <input class="w-full rounded-sm input_search text_responsive" type="search" id="search" name="search"
                    placeholder="Buscar por título, autor, editorial..." autocomplete="off" value="{{ $search ?? '' }}">
            </div>
        </form>
    {{-- </div> --}}

    
    
    {{-- <div class="flex items-center justify-center w-full">
        <div class="block">
            <select id="content-select" autocomplete="off" class="text_responsive w-24">
                <option value="Todo" selected>Todo</option>
                <option value="Autor">Autor</option>
                <option value="Titulo">Título</option>
                <option value="Editorial">Editorial</option>
                <option value="Tema">Tema</option>
                <option value="ISBN">ISBN</option>
            </select>
        </div>
        <div class="input_search_mainContainer text_responsive cursor-pointer ml-4 mr-0 md:mr-4">
            <div class="w-4 h-4 absolute z-50 left-6 top-5 md:left-28 lg:left-32 2xl:left-36 md:top-5 magnifier_icon">
                <i class="fas fa-search"></i>
            </div>
            <input class="w-full rounded-sm input_search text_responsive" type="search" id="search" name="search"
                placeholder="Buscar por título, autor, editorial..." autocomplete="off">
        </div>
    </div> --}}
    <div class="flex mt-3 md:mt-0">
        <div class="w-full md:w-52 whitespace-nowrap">
            <select id="advance-search" autocomplete="off" class="advance_search_select">
                <option value="0" selected>Busqueda avanzada</option>
                <option value="1">Audiovisual</option>
                <option value="2">Caso de estudio</option>
                <option value="3">Congreso</option>
                <option value="4">Conferencia</option>
                <option value="ebooks">E-book</option>
                <option value="6">Infografía</option>
                <option value="book">Libro</option>
                <option value="8">Material gráfico</option>
                <option value="9">Revista</option>
                <option value="10">Seminario</option>
                <option value="investigation-works">Trabajo de investigación</option>
                <option value="12">Tesis</option>
                <option value="podcasts">Podcast</option>
            </select>
        </div>
    </div>

    <x-search-bar.advance_main />

    {{-- <form id="form-search" class="w-full flex" action="{{ route('searchContent') }}" method="GET" style="padding:0.8em;
        background: #91091E 0% 0% no-repeat padding-box;
        box-shadow: 0px 3px 6px #00000080;
        border: 1px solid #C1C1C1;
        border-radius: 4px;">
        <div id="select-search" class="w-2/12" style="">
            <select name="searchType" style=" padding: 0px; border:0;">
                <option value="all" selected>Todo</option>
                <option value="authors">Autor</option>
                <option value="title">Título</option>
                <option value="editorial">Editorial</option>
                <option value="topics">Tema</option>
                <option value="isbn">ISBN</option>
            </select>
        </div>
        <div class="input-search">
            <svg onclick="document.getElementById('form-search').submit();" version="1.1" class="Capa_1" id='capa-4'  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 512.005 512.005" style="position:absolute; left:5px; top:10px; enable-background:new 0 0 512.005 512.005;" xml:space="preserve" width="14px" height="14px">
                <g>
                    <path d="M505.749,475.587l-145.6-145.6c28.203-34.837,45.184-79.104,45.184-127.317c0-111.744-90.923-202.667-202.667-202.667
                        S0,90.925,0,202.669s90.923,202.667,202.667,202.667c48.213,0,92.48-16.981,127.317-45.184l145.6,145.6
                        c4.16,4.16,9.621,6.251,15.083,6.251s10.923-2.091,15.083-6.251C514.091,497.411,514.091,483.928,505.749,475.587z
                            M202.667,362.669c-88.235,0-160-71.765-160-160s71.765-160,160-160s160,71.765,160,160S290.901,362.669,202.667,362.669z"/>
                </g>
            </svg>
            <input type="search" id="search" name="search" placeholder="Buscar por título o autor o editorial o...">
        </div>
        <div class="advance-search" style="">
            <span>Búsqueda avanzada </span>
            <svg style="margin: 0 4px; display: inline-block; fill: white;" version="1.1" class="Capa_1" id='capa-5' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        width="12px" height="12px" viewBox="0 0 451.847 451.847" style="enable-background:new 0 0 451.847 451.847;"
        xml:space="preserve">
                <g>
                    <path d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751
                        c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0
                        c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z"/>
                </g>
            </svg>
        </div>
    </form> --}}

</div>

<script>
        new TomSelect('#content-select', {
            plugins: ['dropdown_input'],
        });
        const advance_search_instance = new TomSelect('#advance-search', {
            plugins: ['dropdown_input'],
        });

        $("#advance-search").change(function(e) {
            valueSelected = $("#advance-search").children("option:selected").val();
            if (valueSelected != 0) {
                showAdvanceForm(valueSelected);                
                toggle_Overflow();                
            }
        });

        function toggle_Overflow() {
            $("body").toggleClass("overflow-hidden");
            if ($("body")[0].classList.value == "") {
            resetSelectedValueOnDropdown();   
            }            
        }

        function showAdvanceForm(valueSelected) {
            $("#advance_search_modal").attr("x-data", "{ open: true }");
            hidePreviousAdvanceForm();
            getTitleAdvanceForm();
            defineAdvanceSearchFormRoute(valueSelected);
            getInputsAdvanceForm(valueSelected).forEach(element => {
                $("#" + element).removeClass("hidden");
            });
        }

        function resetSelectedValueOnDropdown() {

                advance_search_instance.activeOption.classList.remove("active");
                advance_search_instance.clear(true);
                advance_search_instance.setValue(0, true);

        }

        function getTitleAdvanceForm() {
            let title = $("#advance-search").children("option:selected").html()
            $("#advanceSearch_title").html("Búsqueda avanzada " + title );
        }

        function defineAdvanceSearchFormRoute(valueSelected) {
            $("#advanceSearch_form").attr("action", "/" + valueSelected)
        }

        function hidePreviousAdvanceForm() {
            $("#advanceSearch_title").html("Búsqueda avanzada");
            $("#advanceSearch_container").children("div").each(function () {
                $(this).addClass("hidden");
            });
        }

        function getInputsAdvanceForm(valueSelected) {            
            const ebooks = ['campo_autor', 'campo_editorial', 'campo_titulo', 'campo_isbn', 'campo_tema', 'campo_pais'];
            const books = ['campo_autor', 'campo_editorial', 'campo_titulo', 'campo_isbn', 'campo_tema', 'campo_pais'];
            const investigationWorks = ['campo_autor', 'campo_editorial', 'campo_titulo', 'campo_isbn', 'campo_tema', 'campo_pais'];
            const podcasts = ['campo_autor', 'campo_editorial', 'campo_titulo', 'campo_duracion', 'campo_tema', 'campo_pais'];

            switch (valueSelected) {                 
                case "ebooks":
                    return ebooks;
                    break;
                case "books":
                    return ebooks;
                    break;
                case "investigation-works":
                    return investigationWorks;
                    break;
                case "podcasts":
                    return podcasts;
                    break;
                default:
                    return ebooks;
                    break;
            }
        }

</script>
