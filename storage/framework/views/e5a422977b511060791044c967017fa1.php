<?php if (isset($component)) { $__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout2','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>


    <header id="header" class="header" >
        <div class="header-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-xl-5">
                        <div class="text-container">
                            <h1>Bienvenue sur Redal !</h1>
                            <p class="p-large">Notre plateforme simplifie la gestion des files d'attente pour tous vos services. Planifiez vos visites et suivez vos demandes en temps réel pour une expérience fluide et agréable.</p>
                            <a class="btn-solid-lg page-scroll" href="/ticket-dispenser">Distributeur de Tickets</a>
                            <a class="btn-solid-lg page-scroll" href="/live-queue">File</a>
                        </div> <!-- end of text-container -->
                    </div> <!-- end of col -->
                    <div class="col-lg-6 col-xl-7">
                        <div class="image-container">
                            <div class="img-wrapper">
                                <img class="img-fluid" src="img/homepage.png" alt="alternative">
                            </div> <!-- end of img-wrapper -->
                        </div> <!-- end of image-container -->
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div> <!-- end of container -->
        </div> <!-- end of header-content -->
    </header> <!-- end of header -->

    <div class="cards-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="above-heading"><h1 style="color: #5f4def">DESCRIPTION</h1></div>
                    <h2 class="h2-heading">Gestion de File d'Attente Simplifiée</h2>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
    
            <div class="row">
                <div class="col-lg-4">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <img class="img-fluid" src="img/ticket.png" alt="Système de Distribution de Tickets" style="width: 100%; height: auto;">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Système de Distribution de Tickets</h4>
                            <p>Mettez en place un système efficace pour la distribution et la gestion des tickets d'attente.</p>
                        </div>
                    </div>
                    <!-- end of card -->
                </div> <!-- end of col -->
    
                <div class="col-lg-4">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <img class="img-fluid" src="img/bord.png" alt="Tableau de Bord Administratif" style=" height: 200px;">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Tableau de Bord Administratif</h4>
                            <p>Accédez à un tableau de bord intuitif pour surveiller et gérer les files d'attente et les performances.</p>
                        </div>
                    </div>
                    <!-- end of card -->
                </div> <!-- end of col -->
    
                <div class="col-lg-4">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <img class="img-fluid" src="img/stat.png" alt="Statistiques et Rapports" style=" height: 200px;">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Statistiques et Rapports</h4>
                            <p>Générez des statistiques détaillées et des rapports pour analyser le flux de clients et améliorer l'efficacité.</p>
                        </div>
                    </div>
                    <!-- end of card -->
                </div> <!-- end of col -->
    
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div>
    
     <!-- end of cards-1 -->
    <!-- end of description -->


    <!-- Features -->
    <div id="services" class="tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="above-heading"><h1 style="color: #5f4def">Services</h1></div>
                    <h2 class="h2-heading">Gestion de File d'Attente</h2>
                    <p class="p-heading">Améliorez l'efficacité de votre gestion de file d'attente avec nos services dédiés pour répondre aux besoins de vos clients.</p>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
            <div class="row">
                <div class="col-lg-12">
    
                    <!-- Tabs Links -->
                    <ul class="nav nav-tabs" id="queueTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="nav-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true"><i class="fas fa-list"></i> Gestion des Files</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-tab-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false"><i class="fas fa-clock"></i> Statistiques en Temps Réel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="nav-tab-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false"><i class="fas fa-cog"></i> Gestion des Services et Agences</a>
                        </li>
                    </ul>
                    <!-- end of tabs links -->
    
                    <!-- Tabs Content -->
                    <div class="tab-content" id="queueTabsContent">
    
                        <!-- Tab 1: Gestion des Files -->
                        <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="image-container">
                                        <img class="img-fluid" src="img/gestion-files.png" alt="Gestion des Files d'Attente">
                                    </div> <!-- end of image-container -->
                                </div> <!-- end of col -->
                                <div class="col-lg-6">
                                    <div class="text-container">
                                        <h3>Gestion des Files d'Attente</h3>
                                        <p>Optimisez l'organisation et la distribution des tickets pour minimiser le temps d'attente des clients.</p>
                                        <ul class="list-unstyled li-space-lg">
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Créez et gérez plusieurs files d'attente simultanément</div>
                                            </li>
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Attribuez des priorités et ajustez dynamiquement l'ordre de service</div>
                                            </li>
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Suivez l'état d'avancement et la disponibilité des services</div>
                                            </li>
                                        </ul>
                                        <a class="btn-solid-reg popup-with-move-anim" href="/register">S'inscrire</a>
                                    </div> <!-- end of text-container -->
                                </div> <!-- end of col -->
                            </div> <!-- end of row -->
                        </div> <!-- end of tab-pane -->
                        <!-- end of Tab 1 -->
    
                        <!-- Tab 2: Statistiques en Temps Réel -->
                        <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tab-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="image-container">
                                        <img class="img-fluid" src="img/statistiques.png" alt="Statistiques en Temps Réel">
                                    </div> <!-- end of image-container -->
                                </div> <!-- end of col -->
                                <div class="col-lg-6">
                                    <div class="text-container">
                                        <h3>Statistiques en Temps Réel</h3>
                                        <p>Accédez à des données précises pour optimiser l'efficacité opérationnelle et améliorer l'expérience client.</p>
                                        <ul class="list-unstyled li-space-lg">
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Visualisez les statistiques d'occupation et de flux client</div>
                                            </li>
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Analysez les temps d'attente moyens</div>
                                            </li>
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Générez des rapports détaillés pour chaque file d'attente</div>
                                            </li>
                                        </ul>
                                        <a class="btn-solid-reg popup-with-move-anim" href="/register">S'inscrire</a>
                                    </div> <!-- end of text-container -->
                                </div> <!-- end of col -->
                            </div> <!-- end of row -->
                        </div> <!-- end of tab-pane -->
                        <!-- end of Tab 2 -->
    
                        <!-- Tab 3: Personnalisation -->
                        <!-- Tab 3: Gestion des Services et Agences -->
                        <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tab-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="image-container">
                                        <img class="img-fluid" src="img/services-agences.png" alt="Gestion des Services et Agences">
                                    </div> <!-- end of image-container -->
                                </div> <!-- end of col -->
                                <div class="col-lg-6">
                                    <div class="text-container">
                                        <h3>Gestion des Services et Agences</h3>
                                        <p>Organisez et gérez efficacement les services et les agences de votre système de gestion de file d'attente.</p>
                                        <ul class="list-unstyled li-space-lg">
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Créez et configurez différents types de services et d'agences</div>
                                            </li>
                                            
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Gérez la disponibilité et la capacité d'accueil par service</div>
                                            </li>
                                            
                                            <li class="media">
                                                <i class="fas fa-square"></i>
                                                <div class="media-body">Visualisez les statistiques et rapports spécifiques à chaque agence et service</div>
                                            </li>
                            
                                        </ul>
                                        <a class="btn-solid-reg popup-with-move-anim" href="/register">S'inscrire</a>
                                    </div> <!-- end of text-container -->
                                </div> <!-- end of col -->
                            </div> <!-- end of row -->
                        </div> <!-- end of tab-pane -->
<!-- end of Tab 3: Gestion des Services et Agences -->
 <!-- end of tab-pane -->
                        <!-- end of Tab 3 -->
                        
                    </div> <!-- end of tab content -->
                    <!-- end of tabs content -->
    
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div>

    <div id="services" class="tabs">
        <div class="container">
        </div>
    </div>


    <!-- Footer -->
    <svg class="footer-frame" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1920 79"><defs><style>.cls-2{fill:#023047;}</style></defs><title>footer-frame</title><path class="cls-2" d="M0,72.427C143,12.138,255.5,4.577,328.644,7.943c147.721,6.8,183.881,60.242,320.83,53.737,143-6.793,167.826-68.128,293-60.9,109.095,6.3,115.68,54.364,225.251,57.319,113.58,3.064,138.8-47.711,251.189-41.8,104.012,5.474,109.713,50.4,197.369,46.572,89.549-3.91,124.375-52.563,227.622-50.155A338.646,338.646,0,0,1,1920,23.467V79.75H0V72.427Z" transform="translate(0 -0.188)"/></svg>
    <div class="footer">
        <div class="container">
            <center>
                <div class="footer-col first">
                    <h4>À propos de notre système</h4>
                    <p class="p-small">Nous sommes dédiés à simplifier la gestion des files d'attente pour une meilleure expérience client.</p>
                </div>
            </center>

                   
 <!-- end of col -->
                 <!-- end of col -->
                 <!-- end of col -->
 <!-- end of row -->
        </div> <!-- end of container -->
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="p-small">Copyright &copy; <?php echo e(date('Y')); ?> <a href="/">Redal</a>. All rights reserved.</p>

                </div> <!-- end of col -->
            </div> <!-- enf of row -->
        </div> <!-- end of container -->
    </div> 
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9)): ?>
<?php $attributes = $__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9; ?>
<?php unset($__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9)): ?>
<?php $component = $__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9; ?>
<?php unset($__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9); ?>
<?php endif; ?><?php /**PATH D:\Documents\stage\project\resources\views/home.blade.php ENDPATH**/ ?>