<?php $__env->startSection('title', 'Contact Us '); ?>

<?php $__env->startSection('content'); ?>
<style type="text/css">
    .form-control{
        background-color: #ffff !important;
    }
</style>
<div id="contact-page" class="page">    
    <section class="page-content">
        <div class="container">
            <div class="row">                   
                <div class="col-sm-12">
                    <h3>Kontakt</h3>
                </div>
            </div>
            <div class="row">                   
                <div class="col-sm-6">
                    <p>Wir würden gerne von Ihnen hören. Erzählen Sie uns ein wenig über sich und Ihre Art von Frage.</p>
                    <div id="contact-form">
                        <div class="panel-body">
                            <form class="form-horizontal" id="contact_form" method="POST" action="{{route('contact.us')}}">
                                    <?php echo e(csrf_field()); ?>
                                
                                <div class="form-group">
                                    <label for="your_name">Name*</label>
                                    <input type="text"  name="name" id="input-name" required  <?php if( Auth::check() ): ?> value="<?php echo e(Auth::user()->first_name); ?>"  <?php endif; ?> class="form-control" placeholder="Name*" />                           
                                </div>
                                <div class="form-group">
                                    <label for="your_email">E-Mail*</label>
                                    <input type="email"  name="email" required <?php if( Auth::check() ): ?> value="<?php echo e(Auth::user()->email); ?>"  <?php endif; ?>  id="input-email" class="form-control" placeholder="E-Mail*" />                                                
                                </div>
                                
                                <div class="form-group">
                                    <label for="your_message">Beschreibung*</label>
                                    <textarea class="form-control" required name="message" id="input-message" rows="8" placeholder="Geben Sie Ihre Beschreibung ein*"></textarea>                                                      
                                </div>
                                
                                <div class="buttons">
                                    <input  type="submit" id="btn-contact"  value="NACHRICHT SENDEN" data-loading-text="Sending..."  class="btn btn-info" style="float: right;">
                                </div>
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="contact-info">
                        <h3>Kontaktinformation</h3>                        
                        <ul class="ul">
                               <li>
                                <p><i class="fa fa-pin"></i> Adresse : Königsberger Str. 240 , 40231 Düsseldorf</p>
                            </li>
                            <li>
                                <p><i class="fa fa-phone"></i> +49 211 69587089</p>
                            </li>
                            <li>
                                <p><i class="fa fa-comments-o"></i> Chat</p>
                            </li>
                            <li>
                                <p><i class="fa fa-envelope"></i> Info@3now.de</p>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">var route='<?php echo (route("contact")); ?>';</script>
<script type="text/javascript" src="<?php echo e(url('/asset/front/js/contact.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('website.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>