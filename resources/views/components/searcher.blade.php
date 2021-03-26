<div class="searcher w-11/12 lg:w-8/12 xl:w-6/12 m-auto" >
<form id="form-search" class="w-full flex" action="{{ route('searcher') }}" method="GET" style="height: 54px; padding:12px;
background: #91091E 0% 0% no-repeat padding-box;
box-shadow: 0px 3px 6px #00000080;
border: 1px solid #C1C1C1;
border-radius: 4px;">
    <div class="w-2/12" style="background: #FFFFFF 0% 0% no-repeat padding-box;
    box-shadow: 0px 1px 1px #00000066;
    border: 1px solid #383E56;">
        <select name="searchType" style="width: 100%; height: -webkit-fill-available; padding: 0px 0 0 15px; border:0;">
            <option value="Todo" selected>Todo</option>
            <option value="Autor">Autor</option>
            <option value="Título">Título</option>
            <option value="Editorial">Editorial</option>
            <option value="Tema">Tema</option>
            <option value="ISBN">ISBN</option>
        </select>
    </div>
    <div class="input-search" style="position: relative; margin: 0 8px; width: 55%; background: #FFFFFF 0% 0% no-repeat padding-box;
    border: 1px solid #383E56;
    border-radius: 4px;">
        <svg onclick="document.getElementById('form-search').submit();" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 512.005 512.005" style="position:absolute; left:5px; top:6px; enable-background:new 0 0 512.005 512.005;" xml:space="preserve" width="14px" height="14px">
            <g>
                <path d="M505.749,475.587l-145.6-145.6c28.203-34.837,45.184-79.104,45.184-127.317c0-111.744-90.923-202.667-202.667-202.667
                    S0,90.925,0,202.669s90.923,202.667,202.667,202.667c48.213,0,92.48-16.981,127.317-45.184l145.6,145.6
                    c4.16,4.16,9.621,6.251,15.083,6.251s10.923-2.091,15.083-6.251C514.091,497.411,514.091,483.928,505.749,475.587z
                        M202.667,362.669c-88.235,0-160-71.765-160-160s71.765-160,160-160s160,71.765,160,160S290.901,362.669,202.667,362.669z"/>
            </g>
        </svg>
        <input type="search" id="search" name="search" placeholder="Buscar por título o autor o editorial o..." style=" padding-left:24px; width: 100%; border:0; height: -webkit-fill-available;">
    </div>
    <div class="" style="width: 28.3%; background: #91091E; color:white; text-align: center; box-shadow: 0px 1px 1px #00000066;
    border: 1px solid #FFFFFF;">
        <span>Búsqueda avanzada </span>
        <svg style="margin: 0 4px; display: inline-block; fill: white;" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="12px" height="12px" viewBox="0 0 451.847 451.847" style="enable-background:new 0 0 451.847 451.847;"
	 xml:space="preserve">
            <g>
                <path d="M225.923,354.706c-8.098,0-16.195-3.092-22.369-9.263L9.27,151.157c-12.359-12.359-12.359-32.397,0-44.751
                    c12.354-12.354,32.388-12.354,44.748,0l171.905,171.915l171.906-171.909c12.359-12.354,32.391-12.354,44.744,0
                    c12.365,12.354,12.365,32.392,0,44.751L248.292,345.449C242.115,351.621,234.018,354.706,225.923,354.706z"/>
            </g>
        </svg>
    </div>
</form>
</div>