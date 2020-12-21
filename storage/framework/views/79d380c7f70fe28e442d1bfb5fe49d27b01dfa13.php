<div class="site-sidebar">

   <div class="custom-scroll">

      <ul class="sidebar-menu">

         <li>

            <a href="<?php echo e(route('admin.dashboard')); ?>" class="waves-effect waves-light">

            <span class="s-icon"><i class="ti-control-record"></i></span>

            <span class="s-text">Instrumententafel</span>

            </a>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-stats-up"></i></span>

            <span class="s-text">Siedlung</span>

            </a>

            <ul>

               <li class="with-sub">

                  <a href="#" class="waves-effect  waves-light">

                  <span class="s-text">Kontoinformation</span>

                  <span class="s-caret"><i class="fa fa-angle-down"></i></span></a>

                  <ul>

                     <li><a href="<?php echo e(url('admin/new_account')); ?>">Neues Konto</a></li>

                     <li><a href="<?php echo e(url('admin/approved_account')); ?>">Genehmigtes Konto</a></li>

                  </ul>

               </li>

               <li class="with-sub">

                  <a href="#" class="waves-effect  waves-light">

                  <span class="s-text">Info zurückziehen</span>

                  <span class="s-caret"><i class="fa fa-angle-down"></i></span></a>

                  <ul>

                     <li><a href="<?php echo e(url('admin/new_withdraw')); ?>">Anfragen zurückziehen</a></li>

                     <li><a href="<?php echo e(url('admin/approved_withdraw')); ?>">Genehmigter Rückzug</a></li>

                  </ul>

               </li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-zoom-in"></i></span>

            <span class="s-text">Zone</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.zone.index')); ?>">Alle Zone</a></li>

               <li><a href="<?php echo e(route('admin.zone.create')); ?>">Zone hinzufügen</a></li>

            </ul>

         </li>

         <li>

            <a href="/admin/coupons" class="waves-effect waves-light">

            <span class="s-icon"><i class="ti-control-record"></i></span>

            <span class="s-text">Gutschein</span>

            </a>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-comments"></i></span>

            <span class="s-text">Push-Benachrichtigung</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.pushnotification.index')); ?>">Alle Push-Benachrichtigungen</a></li>

               <li><a href="<?php echo e(route('admin.pushnotification.create')); ?>">Push-Benachrichtigung hinzufügen</a></li>

            </ul>

         </li>

         <li>

            <a href="<?php echo e(route('admin.heatmap')); ?>" class="waves-effect waves-light">

            <span class="s-icon"><i class="ti-flickr-alt"></i></span>

            <span class="s-text">Vogelauge</span>

            </a>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-user"></i></span>

            <span class="s-text">Benutzer</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.user.index')); ?>">Alle Benutzer</a></li>

               <li><a href="<?php echo e(route('admin.user.create')); ?>">Nutzer hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="<?php echo e(route('admin.contact')); ?>" class="waves-effect  waves-light">

            <span class="s-icon"><i class="ti-comment-alt"></i></span>

            <span class="s-text">Abfrage</span>

            </a>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-infinite"></i></span>

            <span class="s-text">Treiber</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.provider.index')); ?>">Alle Fahrer</a></li>

               <li><a href="<?php echo e(route('admin.provider.create')); ?>">Treiber hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-headphone"></i></span>

            <span class="s-text">Dispatcher</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.dispatch-manager.index')); ?>">Alle Dispatcher</a></li>

               <li><a href="<?php echo e(route('admin.dispatch-manager.create')); ?>">Dispatcher hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-rocket"></i></span>

            <span class="s-text">Verkäufer</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.fleet.index')); ?>">Anbieter auflisten</a></li>

               <li><a href="<?php echo e(route('admin.fleet.create')); ?>">Neuen Anbieter hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-layout-grid2-thumb"></i></span>

            <span class="s-text">Konto</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.account-manager.index')); ?>">Alle Konten</a></li>

               <li><a href="<?php echo e(route('admin.account-manager.create')); ?>">Konto hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-files"></i></span>

            <span class="s-text">Finanzen</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.ride.statement')); ?>">Reiseeinnahmen</a></li>

               <li><a href="<?php echo e(route('admin.payment')); ?>">Reiseverlauf</a></li>

               <li><a href="<?php echo e(route('admin.ride.statement.provider')); ?>">Fahrer verdienen</a></li>

               <li><a href="<?php echo e(route('admin.ride.statement.today')); ?>">Tägliche Einnahmen</a></li>

               <li><a href="<?php echo e(route('admin.ride.statement.monthly')); ?>">Monatliche Einnahmen</a></li>

               <li><a href="<?php echo e(route('admin.ride.statement.yearly')); ?>">Jahresumsatz</a></li>

            </ul>

         </li>

         <li>

            <a href="<?php echo e(route('admin.map.index')); ?>" class="waves-effect waves-light">

            <span class="s-icon"><i class="ti-map-alt"></i></span>

            <span class="s-text">Live-Standort</span>

            </a>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-star"></i></span>

            <span class="s-text">Bewertungen &amp; Bewertungen</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.user.review')); ?>">Benutzerbewertungen</a></li>

               <li><a href="<?php echo e(route('admin.provider.review')); ?>">Treiberbewertungen</a></li>

            </ul>

         </li>

         <li>

            <a href="<?php echo e(route('admin.requests.index')); ?>" class="waves-effect  waves-light">

            <span class="s-icon"><i class="ti-pie-chart"></i></span>

            <span class="s-text">Alle fahren</span>

            </a>

         </li>

         <li>

            <a href="<?php echo e(route('admin.requests.scheduled')); ?>" class="waves-effect  waves-light">

            <span class="s-icon"><i class="ti-timer"></i></span>

            <span class="s-text">Geplante Fahrt</span>

            </a>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-car"></i></span>

            <span class="s-text">Fahrzeug</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.service.index')); ?>">Alle Fahrzeuge</a></li>

               <li><a href="<?php echo e(route('admin.service.create')); ?>">Fahrzeug hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-layout-media-overlay-alt-2"></i></span>

            <span class="s-text">Fahrzeugkartierung</span>

            </a>

            <ul>

               <li><a href="<?php echo e(url('admin/allocation_list')); ?>">Kartiertes Fahrzeug</a></li>

               <li><a href="<?php echo e(url('admin/allocation')); ?>">Neue Karte</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-layout-media-overlay"></i></span>

            <span class="s-text">Tarifeinstellungen</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.fare_settings')); ?>">Tarifplanliste</a></li>

               <li><a href="<?php echo e(route('admin.fare.settings.create')); ?>">Neuen Tarifplan hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-exchange-vertical"></i></span>

            <span class="s-text">Unterstützung</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.support-manager.index')); ?>">Alle Executive</a></li>

               <li><a href="<?php echo e(route('admin.support-manager.create')); ?>">Neue Führungskraft hinzufügen</a></li>

            </ul>

            <ul>

               <li><a href="#">Benachrichtigung</a></li>

               <li><a href="<?php echo e(route('admin.openTicket')); ?>">Offenes Ticket</a></li>

               <li><a href="<?php echo e(route('admin.closeTicket')); ?>">Ticket schließen</a></li>

               <!-- <li><a href="#">Activity</a></li> -->

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-layout-tab"></i></span>

            <span class="s-text">Unterlagen</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.document.index')); ?>">Alle Dokumente</a></li>

               <li><a href="<?php echo e(route('admin.document.create')); ?>">Dokument hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-map"></i></span>

            <span class="s-text">Standort</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.country.index')); ?>">Alle Länder</a></li>

               <li><a href="<?php echo e(route('admin.state.index')); ?>">Alle Staaten</a></li>

               <li><a href="<?php echo e(route('admin.city.index')); ?>">Alle Städte</a></li>

               <li><a href="<?php echo e(route('admin.location.create')); ?>">Neue hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-layout-media-left-alt"></i></span>

            <span class="s-text">CMS</span>

            </a>

            <ul>

               <li><a href="<?php echo e(url('/admin/page')); ?>">Alle Seiten</a></li>

               <li><a href="<?php echo e(url('/admin/page/create')); ?>">Seiten hinzufügen</a></li>

               <li><a href="<?php echo e(route('admin.cms-manager.index')); ?>">CMS Exekutive</a></li>

               <li><a href="<?php echo e(route('admin.cms-manager.create')); ?>">Neue Exekutive hinzufügen</a></li>

               <!--<li><a href="#">CMS Users</a></li>

                  <li><a href="#">Add User</a></li>-->

               <li><a href="#">Übersetzung</a></li>

               <li><a href="#">Neue Übersetzung hinzufügen</a></li>

               <li><a href="<?php echo e(url('/admin/blog')); ?>">Alle Blogs</a></li>

               <li><a href="<?php echo e(url('/admin/page/create')); ?>">Neue Blogs hinzufügen</a></li>

            </ul>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-layout-media-right"></i></span>

            <span class="s-text">CRM</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.crm-manager.index')); ?>">CRM Exekutive</a></li>

               <li><a href="<?php echo e(route('admin.crm-manager.create')); ?>">Neue Exekutive hinzufügen</a></li>

               <li><a href="">Alle Ticket</a></li> 

               <li><a href="#">Offenes Ticket</a></li>

               <li><a href="#">Ticket schließen</a></li>

               <!-- <li><a href="#">Activity</a></li> -->

            </ul>

         </li>

       

         <li>

            <a href="<?php echo e(route('admin.payment')); ?>" class="waves-effect  waves-light">

            <span class="s-icon"><i class="ti-download"></i></span>

            <span class="s-text">Zahlungshistorie</span>

            </a>

         </li>

         <li>

            <a href="<?php echo e(route('admin.settings.payment')); ?>" class="waves-effect  waves-light">

            <span class="s-icon"><i class="ti-money"></i></span>

            <span class="s-text">Zahlungseinstellungen</span>

            </a>

         </li>

         <li>

            <a href="<?php echo e(route('admin.settings')); ?>" class="waves-effect  waves-light">

            <span class="s-icon"><i class="ti-settings"></i></span>

            <span class="s-text">Webeinstellungen</span>

            </a>

         </li>

         <li class="with-sub">

            <a href="#" class="waves-effect  waves-light">

            <span class="s-caret"><i class="fa fa-angle-down"></i></span>

            <span class="s-icon"><i class="ti-themify-favicon"></i></span>

            <span class="s-text">Referenzen</span>

            </a>

            <ul>

               <li><a href="<?php echo e(route('admin.testimonial.index')); ?>">Testimonials auflisten</a></li>

               <li><a href="<?php echo e(route('admin.testimonial.create')); ?>">Neues Testimonial hinzufügen</a></li>

            </ul>

         </li>

         <li class="compact-hide">

            <a href="<?php echo e(url('/admin/logout')); ?>"

               onclick="event.preventDefault();

               document.getElementById('logout-form').submit();">

            <span class="s-icon"><i class="ti-power-off"></i></span>

            <span class="s-text">Ausloggen</span>

            </a>

            <form id="logout-form" action="<?php echo e(url('/admin/logout')); ?>" method="POST" style="display: none;">

               <?php echo e(csrf_field()); ?>


            </form>

         </li>

      </ul>

   </div>

</div>