<div class="navigation">
    <div class="container  flex-between-center">
        <div class="flex-start-center" style="gap: 1rem;">
            <a href="{{ route('manager_project_home', ['building' => $building->id]) }}"
               class="navigation-btn @if($num == 1) active @endif">プロジェクトホーム</a>
            <a href="{{ route('manager_project_customer', ['building' => $building->id]) }}"
               class="navigation-btn @if($num == 2) active @endif">顧客分析</a>
           <a href="{{ route('manager_project_contents', ['building' => $building->id]) }}"
               class="navigation-btn @if($num == 3) active @endif">コンテンツ管理</a>

           <a href=""
               class="navigation-btn @if($num == 4) active @endif">アクセスログ</a>
        </div>
        <a class="navigation-btn active">プレゼンモード</a>
    </div>
</div>


