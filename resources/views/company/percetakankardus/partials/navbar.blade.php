         <nav id="mainNav">
             <div class="container">
                 <div class="navBar">
                     <div class="logo">
                         @php
                             if (!empty($sistem)) {
                                 $words = explode(' ', $sistem['logo']);
                                 $word = implode(' ', array_splice($words, 0, 5));
                                 $link = 'storage/sistem/' . $word[0] . $word[1] . '/' . $word[2] . $word[3] . '/';
                             }
                         @endphp
                         <a class="navbar-brand" href="asdf"><img
                                 src="{{ !empty($sistem) ? url($link . $sistem['logo']) : '' }}" alt="..." /></a>
                     </div>
                     <div class="nav-links">
                         <div class="sidebar-logo">
                             <span>
                                 <a class="navbar-brand" href="#">
                                     <img src="{{ !empty($sistem) ? url($link . $sistem['logo']) : '' }}"
                                         alt="..." /></a>
                             </span>
                         </div>
                         <ul class="links">
                             <li class="list-item">
                                 <a id="produk" href="#">Produk</a><i
                                     class='bx bx-chevron-down arrow animate'></i>
                                 <div class="parent-submenu sub-menu fade-up">
                                     <div class="row">
                                         @php
                                             $x = 0;
                                             $baris = 11;
                                         @endphp
                     </div>
                 </div>
                 </li>
                 <li class="list-item">
                     <a id="follow" href="#">Follow</a><i class='bx bx-chevron-down arrow animate-1'></i>
                     <ul class="follow parent-submenu small-menu fade-up">
                         <li><a target="_blank"
                                 href="https://www.instagram.com/{{ !empty($sistem) ? $sistem['instagram'] : '' }}">Instagram</a>
                         </li>
                         <li><a target="_blank"
                                 href="https://www.facebook.com/{{ !empty($sistem) ? $sistem['facebook'] : '' }}/">Facebook</a>
                         </li>
                     </ul>
                 </li>
                 <li class="list-item">
                     <a id="follow" href="#">Marketplace</a><i class='bx bx-chevron-down arrow animate-1'></i>
                     <ul class="follow parent-submenu small-menu fade-up">
                         <li><a target="_blank"
                                 href="https://www.tokopedia.com/{{ !empty($sistem) ? $sistem['tokopedia'] : '' }}">Tokopedia</a>
                         </li>
                         <li><a target="_blank"
                                 href="https://shopee.co.id/{{ !empty($sistem) ? $sistem['shopee'] : '' }}">Shopee</a>
                         </li>
                         <li><a target="_blank"
                                 href="https://www.lazada.co.id/shop/{{ !empty($sistem) ? $sistem['lazada'] : '' }}">lazada</a>
                         </li>
                     </ul>
                 </li>
                 <li class="list-item"><a href="asdf">Profil</a></li>
                 <li class="list-item"><a href="sadf">Kontak</a></li>
                 <li class="icon-right">
                     <a id="phone" class="nav-link" href="#" data-bs-toggle="dropdown"><i
                             class='bx bx-mobile-alt icon-nav'></i></a>
                     <div class="phone parent-submenu small-menu fade-up">
                         <div class="d-flex flex-column">
                             <h6 class="ps-2 pt-3">CS Bandung</h6>
                             <div class="d-inline-flex p-2"><i class='bx bxs-phone-incoming icon-navitem'></i><span
                                     class="text-icon">{{ !empty($sistem) ? $sistem['telp-kantor-bandung'] : '' }}</span>
                             </div>
                             <div class="d-inline-flex p-2"><i class='bx bx-mobile-alt icon-navitem '></i>
                                 <span class="text-icon">{{ !empty($sistem) ? $sistem['cs-bandung'] : '' }}</span>
                             </div>
                             <h6 class="ps-2">CS Jakarta</h6>
                             <div class="d-inline-flex p-2"><i class='bx bx-mobile-alt icon-navitem '></i>
                                 <span class="text-icon">{{ !empty($sistem) ? $sistem['cs-jakarta'] : '' }}</span>
                             </div>
                         </div>
                     </div>
                 </li>
                 <li>
                     <a id="time" class="nav-link" href="#"><i class='bx bx-time-five icon-nav'></i></a>
                     <div class="time parent-submenu small-menu fade-up">
                         <div class="d-flex flex-column">
                            
                         </div>
                     </div>
                 </li>
                 <li>
                     <a id="search" class="nav-link" href="#"><i class='bx bx-search icon-nav'></i></a>
                     <div class="parent-submenu search-menu fade-up">
                         <div class="row">
                             <div class="col-12">
                                 <div class="search">
                                     <input type="text" placeholder="search" id="input-search">
                                     <button class="btnSearch"
                                         onclick="document.getElementById('input-search').value = ''" href="#"><i
                                             class='bx bx-x'></i></button>
                                     <a class="btn-search" href=""><i class='bx bx-search-alt'></i></a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </li>
                 <li>
                     @php
                         $jakarta = str_replace(' ', '%20', !empty($sistem) ? $sistem['text-wa-jakarta'] : '');
                         $bandung = str_replace(' ', '%20', !empty($sistem) ? $sistem['text-wa-bandung'] : '');
                     @endphp
                     <a id="wa" class="nav-link" href="#" data-bs-toggle="dropdown"><i
                             class='bx bxl-whatsapp icon-nav'></i></a>
                     <div class="wa parent-submenu small-menu fade-up">
                         <div class="d-flex flex-column">
                             <h6 class="ps-2">Bandung</h6>
                             <div class="d-inline-flex p-2">
                                 <a class="wa-web"
                                     href="https://web.whatsapp.com/send?phone={{ !empty($sistem) ? $sistem['wa-bandung'] : '' }}&amp;text={{ $bandung }}"
                                     target="_blank">
                                     {{ !empty($sistem) ? $sistem['wa-bandung'] : '' }}
                                 </a>
                                 <a class="wa-mobile"
                                     href="https://api.whatsapp.com/send?phone={{ !empty($sistem) ? $sistem['wa-bandung'] : '' }}&amp;text={{ $bandung }}"
                                     target="_blank">
                                     {{ !empty($sistem) ? $sistem['wa-bandung'] : '' }}
                                 </a>
                             </div>
                             <h6 class="ps-2">Jakarta</h6>
                             <div class="d-inline-flex p-2">
                                 <a class="wa-web"
                                     href="https://web.whatsapp.com/send?phone={{ !empty($sistem) ? $sistem['wa-jakarta'] : '' }}&amp;text={{ $jakarta }}"
                                     target="_blank">
                                     {{ !empty($sistem) ? $sistem['wa-jakarta'] : '' }}
                                 </a>
                                 <a class="wa-mobile"
                                     href="https://api.whatsapp.com/send?phone={{ !empty($sistem) ? $sistem['wa-jakarta'] : '' }}&amp;text={{ $jakarta }}"
                                     target="_blank">
                                     {{ !empty($sistem) ? $sistem['wa-jakarta'] : '' }}
                                 </a>
                             </div>
                         </div>
                     </div>
                 </li>
                 </ul>
             </div>
             <div class="d-inline-flex icon-wa">
                 <a class="nav-link"
                     href="https://api.whatsapp.com/send?phone={{ !empty($sistem) ? $sistem['wa-bandung'] : '' }}&amp;text={{ $bandung }}">
                     <i class='bx bxl-whatsapp icon-navitem'></i>
                 </a>
             </div>
             <div id="nav-icon3">
                 <span></span>
                 <span></span>
                 <span></span>
                 <span></span>
             </div>
             </div>
             </div>
         </nav>
