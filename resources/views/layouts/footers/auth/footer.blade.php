<footer class="pt-4">
    <div class="w-full px-6 mx-auto">
        <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
            <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                <div class="leading-normal text-center text-size-sm text-slate-500 {{ (Request::is('rtl') ? 'lg:text-right' : 'lg:text-left') }} ">
                    ©
                    <script>
                        document.write(new Date().getFullYear() + ",");
                    </script>
                    made with <i class="fa fa-heart"></i> for a better web.
                </div>
            </div>
            <div class="w-full max-w-full px-3 mt-0 shrink-0 lg:w-1/2 lg:flex-none">
                <ul class="flex flex-wrap justify-center pl-0 mb-0 list-none lg:justify-end">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 pt-0 pb-1 font-normal transition-colors ease-soft-in-out text-size-sm text-slate-500">
                            Accueil</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>  