<!-- Table -->
<div class="table-container">
    <?php if(isset($error)): ?>
        <div class="no-data">
            <i class="fas fa-exclamation-triangle"></i>
            <h3><?php echo e($error); ?></h3>
            <p>Please try again or contact support.</p>
        </div>
    <?php elseif(empty($pageData)): ?>
        <div class="no-data">
            <i class="fas fa-inbox"></i>
            <h3>No data found</h3>
            <p>No data available.</p>
        </div>
    <?php else: ?>
        <!-- Alert messages removed -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Business Name</th>
                    <th>Email</th>
                    <th>WhatsApp</th>
                    <th>Who Called?</th>
                    <th>Right Time For Call</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pageData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($row['full_name'] ?? ''); ?></td>
                        <td><?php echo e($row['business_name'] ?? ''); ?></td>
                        <td>
                            <?php if(!empty($row['email'])): ?>
                                <a href="mailto:<?php echo e($row['email']); ?>" class="email-link">
                                    <i class="fas fa-envelope me-1"></i><?php echo e($row['email']); ?>

                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($row['whatsapp'])): ?>
                                <?php
                                    $cleanPhone = preg_replace('/[^0-9+]/', '', $row['whatsapp']);
                                ?>
                                <a href="https://wa.me/<?php echo e($cleanPhone); ?>" target="_blank" class="whatsapp-link">
                                    <i class="fab fa-whatsapp me-1"></i><?php echo e($row['whatsapp']); ?>

                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($row['who_called'] ?? ''); ?></td>
                        <td>
                            <?php if(isset($row['best_calling_time']) && !empty($row['best_calling_time'])): ?>
                            <?php
                                $confidence = strtolower($row['best_calling_time']['confidence'] ?? 'low');
                                $backendColor = $row['best_calling_time']['color'] ?? '#6c757d';
                                $bgColor = '#f8f9fa';
                                $textColor = '#495057';
                                $iconColor = '#6c757d';
                                $badgeBg = '#e9ecef';
                                $badgeText = '#495057';
                                
                                if ($confidence === 'high') {
                                    $bgColor = '#e3f2fd';
                                    $textColor = '#1976d2';
                                    $iconColor = '#2196f3';
                                    $badgeBg = '#2196f3';
                                    $badgeText = '#ffffff';
                                } elseif ($confidence === 'medium') {
                                    $bgColor = '#fff3e0';
                                    $textColor = '#f57c00';
                                    $iconColor = '#ff9800';
                                    $badgeBg = '#ff9800';
                                    $badgeText = '#ffffff';
                                } else {
                                    // Use green theme for low confidence (permanent)
                                    $bgColor = '#e8f5e8';
                                    $textColor = '#2e7d32';
                                    $iconColor = '#4caf50';
                                    $badgeBg = '#4caf50';
                                    $badgeText = '#ffffff';
                                }
                            ?>
                            <div class="best-calling-time" style="display: flex; flex-direction: column; gap: 6px; padding: 8px 12px; background: <?php echo e($bgColor); ?>; border-radius: 8px; border-left: 4px solid <?php echo e($iconColor); ?>;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-clock" style="color: <?php echo e($iconColor); ?>; font-size: 1rem;"></i>
                                    <span style="font-weight: 700; color: <?php echo e($textColor); ?>; font-size: 0.9rem;">
                                        <?php echo e($row['best_calling_time']['time_range'] ?? '10:00 AM - 12:00 PM'); ?>

                                    </span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span class="confidence-badge" 
                                          style="font-size: 0.65rem; padding: 3px 8px; border-radius: 12px; background: <?php echo e($badgeBg); ?>; color: <?php echo e($badgeText); ?>; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <?php echo e($row['best_calling_time']['confidence'] ?? 'Low'); ?>

                                    </span>
                                    <span style="font-size: 0.7rem; color: <?php echo e($textColor); ?>; opacity: 0.8;">
                                        <i class="fas fa-phone-alt" style="font-size: 0.6rem;"></i>
                                        <?php echo e($row['best_calling_time']['interaction_count'] ?? 0); ?> calls
                                    </span>
                                </div>
                            </div>
                            <?php else: ?>
                                <?php
                                    // Fallback: Create a stable time recommendation based on lead data
                                    $leadHash = crc32(($row['full_name'] ?? '') . ($row['email'] ?? ''));
                                    $timeRanges = [
                                        ['range' => '9:00 AM - 11:00 AM', 'peak' => '10:00 AM'],   // Morning start
                                        ['range' => '10:00 AM - 12:00 PM', 'peak' => '11:00 AM'], // Late morning
                                        ['range' => '2:00 PM - 4:00 PM', 'peak' => '3:00 PM'],     // Afternoon
                                        ['range' => '5:00 PM - 7:00 PM', 'peak' => '6:00 PM']      // Evening end
                                    ];
                                    // Use lead-specific hash for consistent time assignment
                                    $index = abs($leadHash) % count($timeRanges);
                                    $fallbackTime = $timeRanges[$index];
                                ?>
                                <div class="best-calling-time" style="display: flex; flex-direction: column; gap: 6px; padding: 8px 12px; background: #e3f2fd; border-radius: 8px; border-left: 4px solid #2196f3;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-clock" style="color: #2196f3; font-size: 1rem;"></i>
                                        <span style="font-weight: 700; color: #1976d2; font-size: 0.9rem;">
                                            <?php echo e($fallbackTime['range']); ?>

                                        </span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span class="confidence-badge" 
                                              style="font-size: 0.65rem; padding: 3px 8px; border-radius: 12px; background: #2196f3; color: #ffffff; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Low
                                        </span>
                                        <span style="font-size: 0.7rem; color: #1976d2; opacity: 0.8;">
                                            <i class="fas fa-phone-alt" style="font-size: 0.6rem;"></i>
                                            0 calls
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view" 
                                        onclick="openLeadDetails(<?php echo e($index); ?>, '<?php echo e(request()->routeIs('callingapp.manual-leads') ? 'manual' : 'google'); ?>')"
                                        title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn history" 
                                        onclick="viewLeadCallHistory('<?php echo e($row['full_name'] ?? ''); ?>', '<?php echo e($row['email'] ?? ''); ?>', '<?php echo e($row['business_name'] ?? ''); ?>', '<?php echo e($row['whatsapp'] ?? ''); ?>')"
                                        title="View Call History">
                                    <i class="fas fa-history"></i>
                                </button>
                                <button class="action-btn call" 
                                        onclick="makePhoneCall('<?php echo e($row['whatsapp'] ?? ''); ?>')"
                                        title="Call">
                                    <i class="fas fa-phone"></i>
                                </button>
                                <button class="action-btn meeting" 
                                        onclick="openMeetingModal('<?php echo e($row['full_name'] ?? ''); ?>', '<?php echo e($row['email'] ?? ''); ?>', '<?php echo e($row['whatsapp'] ?? ''); ?>', '<?php echo e($row['business_name'] ?? ''); ?>', '<?php echo e($row['who_called'] ?? ''); ?>')"
                                        title="Schedule Meeting">
                                    <i class="fas fa-calendar"></i>
                                </button>
                                
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if($totalPages > 1): ?>
    <div class="pagination-container">
        <?php
            $isManualLeadsTab = request()->routeIs('callingapp.manual-leads');
            $baseRoute = $isManualLeadsTab ? 'callingapp.manual-leads' : 'callingapp.index';
        ?>
        
        <?php if($page > 1): ?>
            <a href="<?php echo e(route($baseRoute, ['page' => 1, 'search' => $search])); ?>" class="pagination-btn">
                <i class="fas fa-angle-double-left"></i>
            </a>
            <a href="<?php echo e(route($baseRoute, ['page' => $page - 1, 'search' => $search])); ?>" class="pagination-btn">
                <i class="fas fa-angle-left"></i>
            </a>
        <?php endif; ?>

        <?php for($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <a href="<?php echo e(route($baseRoute, ['page' => $i, 'search' => $search])); ?>" 
               class="pagination-btn <?php echo e($i == $page ? 'active' : ''); ?>">
                <?php echo e($i); ?>

            </a>
        <?php endfor; ?>

        <?php if($page < $totalPages): ?>
            <a href="<?php echo e(route($baseRoute, ['page' => $page + 1, 'search' => $search])); ?>" class="pagination-btn">
                <i class="fas fa-angle-right"></i>
            </a>
            <a href="<?php echo e(route($baseRoute, ['page' => $totalPages, 'search' => $search])); ?>" class="pagination-btn">
                <i class="fas fa-angle-double-right"></i>
            </a>
        <?php endif; ?>
        
        <!-- All Recording Button -->
        <a href="<?php echo e(route('recordings.all')); ?>" class="pagination-btn" style="background: var(--success-color); color: white; border-color: var(--success-color); margin-left: 10px;">
            <i class="fas fa-microphone"></i> All Recording
        </a>
    </div>
<?php else: ?>
    <!-- Show All Recording button even when no pagination -->
    <div class="pagination-container">
        <a href="<?php echo e(route('recordings.all')); ?>" class="pagination-btn" style="background: var(--success-color); color: white; border-color: var(--success-color);">
            <i class="fas fa-microphone"></i> All Recording
        </a>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/google-sheets/calling-app-table.blade.php ENDPATH**/ ?>