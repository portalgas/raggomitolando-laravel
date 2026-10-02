<header class="flex flex-wrap sm:justify-start sm:flex-nowrap z-50 w-full py-3 bg-navbar border-b border-navbar-line">
  <nav class="max-w-340 w-full mx-auto px-4 md:px-6 lg:px-8">
    <div class="relative sm:flex sm:items-center">
      <div class="flex items-center justify-between">
        <a class="flex-none font-semibold text-xl text-foreground focus:outline-hidden focus:opacity-80" href="#" aria-label="Brand">Brand</a>
        <div class="sm:hidden">
          <button type="button" class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-x-2 rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-focus disabled:opacity-50 disabled:pointer-events-none" id="hs-navbar-basic-usage-collapse" aria-expanded="false" aria-controls="hs-navbar-basic-usage" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-basic-usage">
            <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
            <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
          </button>
        </div>
      </div>

      <div id="hs-navbar-basic-usage" class="hidden hs-collapse overflow-hidden transition-all duration-300 basis-full grow sm:block" aria-labelledby="hs-navbar-basic-usage-collapse" role="region">
        <div class="flex flex-col gap-y-3 sm:gap-y-0 mt-5 sm:flex-row sm:items-center sm:justify-end sm:mt-0 sm:ps-5">
          <a class="sm:p-2 text-sm font-medium text-primary-active focus:outline-hidden" href="#" aria-current="page">Active</a>

          <div class="hs-dropdown [--strategy:static] sm:[--strategy:absolute] [--adaptive:none]   [--is-collapse:true] sm:[--is-collapse:false] ">
            <button id="hs-mega-menu" type="button" class="hs-dropdown-toggle sm:p-2 flex items-center w-full text-sm text-navbar-nav-foreground hover:text-primary-hover focus:outline-hidden focus:text-primary-focus" aria-haspopup="menu" aria-expanded="false" aria-label="Mega Menu">
              Mega Menu
              <svg class="hs-dropdown-open:-rotate-180 sm:hs-dropdown-open:rotate-0 ms-auto sm:ms-2 shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
            </button>

            <div class="hs-dropdown-menu sm:transition-[opacity,margin] sm:ease-in-out sm:duration-150 hs-dropdown-open:opacity-100 opacity-0 w-full hidden z-10  top-full inset-s-0 min-w-60 sm:bg-dropdown sm:border sm:border-dropdown-line sm:shadow-md rounded-lg py-2 sm:px-2" role="menu" aria-orientation="vertical" aria-labelledby="hs-mega-menu">
              <div class="sm:grid sm:grid-cols-3">
                <div class="flex flex-col">
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    About
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    Services
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    Customer Story
                  </a>
                </div>

                <div class="flex flex-col">
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    Careers
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    Careers: Overview
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    Careers: Apply
                  </a>
                </div>

                <div class="flex flex-col">
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    Log In
                  </a>
                  <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
                    Sign Up
                  </a>
                </div>
              </div>
            </div>
          </div>

          <a class="sm:p-2 text-sm text-navbar-nav-foreground hover:text-primary-hover focus:outline-hidden focus:text-primary-focus" href="#">Project</a>
        </div>
      </div>
    </div>

<!-- Dropdown -->
<div class="hs-dropdown [--auto-close:inside] relative inline-flex">
  <button id="hs-dropdown-default" type="button" class="hs-dropdown-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-focus disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
    Actions
    <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
  </button>

  <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-dropdown border border-dropdown-line shadow-md rounded-lg mt-2 after:h-4 after:absolute after:-bottom-4 after:inset-s-0 after:w-full before:h-4 before:absolute before:-top-4 before:inset-s-0 before:w-full" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-default">
    <div class="p-1 space-y-0.5">
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
        Newsletter
      </a>
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
        Purchases
      </a>
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
        Downloads
      </a>
      <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus" href="#">
        Team Account
      </a>
    </div>
  </div>
</div>
<!-- End Dropdown -->

  </nav>

  <!-- File Upload -->
<div data-hs-file-upload='{
  "url": "/upload",
  "extensions": {
    "default": {
      "class": "shrink-0 size-5"
    },
    "xls": {
      "class": "shrink-0 size-5"
    },
    "zip": {
      "class": "shrink-0 size-5"
    },
    "csv": {
      "icon": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4\"/><path d=\"M14 2v4a2 2 0 0 0 2 2h4\"/><path d=\"m5 12-3 3 3 3\"/><path d=\"m9 18 3-3-3-3\"/></svg>",
      "class": "shrink-0 size-5"
    }
  }
}'>
  <template data-hs-file-upload-preview>
    <div class="p-3 bg-layer border border-layer-line rounded-xl">
      <div class="mb-1 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
          <span class="size-10 flex justify-center items-center bg-layer border border-layer-line text-muted-foreground-1 rounded-lg" data-hs-file-upload-file-icon>
            <img class="rounded-lg hidden" src="data:," alt="" data-dz-thumbnail>
          </span>
          <div>
            <p class="text-sm font-medium text-foreground">
              <span class="truncate inline-block max-w-75 align-bottom" data-hs-file-upload-file-name></span>.<span data-hs-file-upload-file-ext></span>
            </p>
            <p class="text-xs text-muted-foreground-1" data-hs-file-upload-file-size></p>
          </div>
        </div>
        <div class="flex items-center gap-x-2">
          <button type="button" class="text-muted-foreground-1 hover:text-foreground focus:outline-hidden focus:text-foreground" data-hs-file-upload-remove>
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
          </button>
        </div>
      </div>

      <div class="flex items-center gap-x-3 whitespace-nowrap">
        <div class="flex w-full h-2 bg-surface-1 rounded-full overflow-hidden" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" data-hs-file-upload-progress-bar>
          <div class="flex flex-col justify-center rounded-full overflow-hidden bg-primary text-xs text-primary-foreground text-center whitespace-nowrap transition-all duration-500 hs-file-upload-complete:bg-green-500" style="width: 0" data-hs-file-upload-progress-bar-pane></div>
        </div>
        <div class="w-10 text-end">
          <span class="text-sm text-foreground">
            <span data-hs-file-upload-progress-bar-value>0</span>%
          </span>
        </div>
      </div>
    </div>
  </template>

  <div class="cursor-pointer p-12 flex justify-center bg-layer border border-dashed border-line-3 rounded-xl" data-hs-file-upload-trigger>
    <div class="text-center">
      <span class="inline-flex justify-center items-center size-16">
        <svg class="shrink-0 w-16 text-muted-foreground mx-auto" width="73" height="47" viewBox="0 0 73 47" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M54.519 40.4773V6.76876C54.519 3.92686 52.2121 1.62305 49.3664 1.62305H22.7076C19.8619 1.62305 17.555 3.92686 17.555 6.76876V40.4773M54.519 40.4773C54.519 43.3192 52.2121 45.6231 49.3664 45.6231H22.7076C19.8619 45.6231 17.555 43.3192 17.555 40.4773M54.519 40.4773L54.5189 34.6563L48.6564 28.3566L43.2612 34.6373C42.4421 35.5908 40.9662 35.5955 40.141 34.6472L30.3406 23.3844L17.555 36.9154V40.4773M6.20483 9.59424L17.707 7.6798V42.5188L12.6457 43.5828C9.25658 44.2954 5.94238 42.0892 5.29702 38.691L1.14643 16.8357C0.500082 13.4322 2.78322 10.1637 6.20483 9.59424ZM65.8691 9.59424L54.3669 7.6798V42.5188L59.4282 43.5828C62.8173 44.2954 66.1316 42.0892 66.7769 38.691L70.9274 16.8357C71.5738 13.4322 69.2907 10.1637 65.8691 9.59424ZM45.0584 15.3561C45.0584 17.7228 43.1372 19.6413 40.7673 19.6413C38.3974 19.6413 36.4762 17.7228 36.4762 15.3561C36.4762 12.9894 38.3974 11.0708 40.7673 11.0708C43.1372 11.0708 45.0584 12.9894 45.0584 15.3561Z" stroke="currentColor" stroke-width="2"/>
        </svg>
      </span>

      <div class="mt-4 flex flex-wrap justify-center text-sm/6 text-muted-foreground-2">
        <span class="pe-1 font-medium text-foreground">
          Drop your file here or
        </span>
        <span class="bg-layer font-semibold text-primary hover:text-primary-hover rounded-lg decoration-2 hover:underline focus-within:outline-hidden focus-within:ring-2 focus-within:ring-primary-focus focus-within:ring-offset-2">browse</span>
      </div>

      <p class="mt-1 text-xs text-muted-foreground">
        Pick a file up to 2MB.
      </p>
    </div>
  </div>

  <div class="mt-4 space-y-2 empty:mt-0" data-hs-file-upload-previews></div>
</div>
<!-- End File Upload -->
 

  <p class="underline ...">The quick brown fox ...</p>
<p class="overline ...">The quick brown fox ...</p>
<p class="line-through ...">The quick brown fox ...</p>
<p class="no-underline ...">The quick brown fox ...</p>

  <div class="grid grid-cols-3 gap-4">
  <div class="...">01</div>
  <div class="...">02</div>
  <div class="...">03</div>
  <div class="col-span-2 ...">04</div>
  <div class="...">05</div>
  <div class="...">06</div>
  <div class="col-span-2 ...">07</div>
</div>

</header>