<?php $__env->startSection('title', 'Drivers'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1"><span class="s-icon"><i class="ti-infinite"></i></span>&nbsp; Treiberinfo</h5>
            <hr/>
            <a href="<?php echo e(route('admin.provider.create')); ?>" style="margin-left: 1em;" class="btn btn-success shadow-box btn-rounded pull-right"><i class="fa fa-plus"></i> Neuen Treiber hinzufügen</a>
            <table class="table table-striped table-bordered dataTable" id="table-2" style="width:100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Handy, Mobiltelefon</th>
                        <!--<th>Total Ride</th>
                        <th>Accepted Ride</th>
                        <th>Cancelled Ride</th>-->
                        <th>Unterlagen</th>
                        <th>Online</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $provider): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($provider->first_name); ?></td>
                        <td><?php echo e($provider->email); ?></td>
                        <td><?php echo e($provider->mobile); ?></td>
                        <!--<td><?php echo e($provider->total_requests); ?></td>
                        <td><?php echo e($provider->accepted_requests); ?></td>
                        <td><?php echo e($provider->total_requests - $provider->accepted_requests); ?></td>-->
                        <td>
                            <?php if($provider->pending_documents() > 0 || $provider->service == null): ?>
                                <a class="btn shadow-box btn-danger" href="<?php echo e(route('admin.provider.document.index', $provider->id )); ?>"><span><?php echo e($provider->pending_documents()); ?> Doc! </span></a>
                            <?php else: ?>
                                <a class="btn shadow-box btn-success" href="<?php echo e(route('admin.provider.document.index', $provider->id )); ?>">Alles bereit!</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($provider->service): ?>
                                <?php if($provider->service->status == 'active'): ?>
                                    <label class="btn shadow-box btn-primary">Ja</label>
                                <?php else: ?>
                                    <label class="btn shadow-box btn-warning">Nein</label>
                                <?php endif; ?>
                            <?php else: ?>
                                <label class="btn shadow-box btn-danger">N/A</label>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="input-group-btn">
                                <?php if($provider->status == 'approved'): ?>
                                <a class="btn shadow-box btn-danger btn-block" href="<?php echo e(route('admin.provider.disapprove', $provider->id )); ?>"><i class="fa fa-ban"></i></a>
                                <?php else: ?>
                                <a class="btn shadow-box btn-success btn-block" href="<?php echo e(route('admin.provider.approve', $provider->id )); ?>"><i class="fa fa-check"></i></a>
                                <?php endif; ?>
                                <button type="button" 
                                    class="btn shadow-box btn-black btn-block dropdown-toggle"
                                    data-toggle="dropdown">Aktion
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo e(route('admin.provider.request', $provider->id)); ?>" class="btn btn-default"><i class="fa fa-search"></i> Einzelheiten</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(route('admin.provider.statement', $provider->id)); ?>" class="btn btn-default"><i class="fa fa-sticky-note-o"></i> Geschichte</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(route('admin.provider.edit', $provider->id)); ?>" class="btn btn-default"><i class="fa fa-pencil"></i> Profil bearbeiten</a>
                                    </li>
                                    <li>
                                        <form action="<?php echo e(route('admin.provider.destroy', $provider->id)); ?>" method="POST">
                                            <?php echo e(csrf_field()); ?>

                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-default look-a-like" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Löschen</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Handy, Mobiltelefon</th>
                        <!--<th>Total Requests</th>
                        <th>Accepted Requests</th>
                        <th>Cancelled Requests</th>-->
                        <th>Unterlagen</th>
                        <th>Online</th>
                        <th>Aktion</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>