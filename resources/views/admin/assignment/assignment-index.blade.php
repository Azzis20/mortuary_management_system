@extends('admin.layouts.app')
@section('title', 'Staff Assignment')

@section('page-title', 'Staff Assignment Management')

@section('content')

   
    @php
        $success = session()->pull('success');
    @endphp
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

   

    

    {{-- Filter Section --}}
    <div class="card">
        <div class="card-header">
            <h3>Filter Bookings</h3>
        </div>
        <form method="GET" action="{{ route('admin.assignments.index') }}" class="filter-form">
            <div class="filter-grid">
                <div class="form-group">
                    <label for="status">Booking Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Dispatch" {{ request('status') == 'Dispatch' ? 'selected' : '' }}>Dispatch</option>
                        <option value="InCare" {{ request('status') == 'InCare' ? 'selected' : '' }}>In Care</option>
                        <option value="Viewing" {{ request('status') == 'Viewing' ? 'selected' : '' }}>Viewing</option>
                        <option value="Released" {{ request('status') == 'Released' ? 'selected' : '' }}>Released</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="task_type">Task Type</label>
                    <select name="task_type" id="task_type" class="form-control">
                        <option value="">All Tasks</option>
                        <option value="Retrieval" {{ request('task_type') == 'Retrieval' ? 'selected' : '' }}>Retrieval</option>
                        <option value="Embalming" {{ request('task_type') == 'Embalming' ? 'selected' : '' }}>Embalming</option>
                        <option value="Dressing" {{ request('task_type') == 'Dressing' ? 'selected' : '' }}>Dressing</option>
                        <option value="Viewing" {{ request('task_type') == 'Viewing' ? 'selected' : '' }}>Viewing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="task_status">Task Status</label>
                    <select name="task_status" id="task_status" class="form-control">
                        <option value="">All Task Statuses</option>
                        <option value="Pending" {{ request('task_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ request('task_status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ request('task_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="form-group align-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filter
                    </button>
                    <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Bookings with Tasks --}}
    @forelse($bookings as $booking)
        <div class="card booking-card">
            <div class="booking-header">
                <div class="booking-info">
                    <h3 class="booking-title">
                        Booking #{{ $booking->id }} - {{ $booking->deceased->name }}
                    </h3>
                    <div class="booking-meta">
                        <span class="meta-item">
                            <i class="fas fa-user"></i>
                            Client: {{ $booking->client->name }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-box"></i>
                            Package: {{ $booking->package->package_name }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-calendar"></i>
                            Booked: {{ $booking->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
                <div class="booking-status-wrapper">
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $booking->status)) }}">
                        {{ $booking->status }}
                    </span>
                </div>
            </div>

            {{-- Tasks Table --}}
            <div class="tasks-section">
                <div class="tasks-header">
                    <h4>Tasks</h4>
                    <button type="button" class="btn btn-sm btn-primary" onclick="openCreateTaskModal({{ $booking->id }})">
                        <i class="fas fa-plus"></i> Add Task
                    </button>
                </div>

                @if($booking->tasks->count() > 0)
                    <div class="tasks-table-wrapper">
                        <table class="table tasks-table">
                            <thead>
                                <tr>
                                    <th>Task Type</th>
                                    <th>Assigned Staff</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->tasks as $task)
                                    <tr>
                                        <td>
                                            <span class="task-type-badge task-{{ strtolower($task->task_type) }}">
                                                {{ $task->task_type }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($task->staff)
                                                <div class="staff-info">
                                                    <span class="staff-name">{{ $task->staff->name }}</span>
                                                    <span class="staff-role">{{ $task->staff->accountType ?? 'n/a' }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">Not Assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $task->status)) }}">
                                                {{ $task->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="task-notes">{{ $task->notes ?: '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" 
                                                        class="btn-icon btn-icon-primary" 
                                                        onclick="openAssignModal({{ $task->id }}, '{{ $task->staff_id ?? '' }}', '{{ $task->status }}', '{{ addslashes($task->notes ?? '') }}')"
                                                        title="Assign/Update">
                                                    <i class="fas fa-user-edit"></i>
                                                </button>
                                                <form method="POST" 
                                                      action="{{ route('admin.assignments.deleteTask', $task->id) }}" 
                                                      style="display: inline;"
                                                      onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-icon btn-icon-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-tasks"></i>
                        <p>No tasks created for this booking yet.</p>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="card">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>No bookings found matching your criteria.</p>
            </div>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($bookings->hasPages())
        <div class="pagination-wrapper">
            {{ $bookings->links() }}
        </div>
    @endif

    {{-- Assign Staff Modal --}}
    <div id="assignModal" class="task-modal" style="display: none;">
        <div class="task-modal-overlay" onclick="closeAssignModal()"></div>
        <div class="task-modal-content">
            <div class="task-modal-header">
                <h3>Assign Staff & Update Task</h3>
                <button type="button" class="modal-close" onclick="closeAssignModal()">&times;</button>
            </div>
            <form method="POST" id="assignForm" action="">
                @csrf
                @method('PUT')
                <div class="task-modal-body">
                    <div class="form-group">
                        <label for="staff_id" class="form-label">Assign Staff Member</label>
                        <select name="staff_id" id="staff_id" class="form-control" required>
                            <option value="">Select Staff</option>
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }} - {{ $member->accountType ?? 'staff' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Task Status</label>
                        <select name="status" id="task_status_modal" class="form-control" required>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add any relevant notes..."></textarea>
                    </div>
                </div>
                <div class="task-modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAssignModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Assignment</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Create Task Modal --}}
    <div id="createTaskModal" class="task-modal" style="display: none;">
        <div class="task-modal-overlay" onclick="closeCreateTaskModal()"></div>
        <div class="task-modal-content">
            <div class="task-modal-header">
                <h3>Create New Task</h3>
                <button type="button" class="modal-close" onclick="closeCreateTaskModal()">&times;</button>
            </div>
            <form method="POST" id="createTaskForm" action="">
                @csrf
                <div class="task-modal-body">
                    <div class="form-group">
                        <label for="task_type_create" class="form-label">Task Type</label>
                        <select name="task_type" id="task_type_create" class="form-control" required>
                            <option value="">Select Task Type</option>
                            <option value="Retrieval">Retrieval</option>
                            <option value="Embalming">Embalming</option>
                            <option value="Dressing">Dressing</option>
                            <option value="Viewing">Viewing</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="staff_id_create" class="form-label">Assign Staff Member (Optional)</label>
                        <select name="staff_id" id="staff_id_create" class="form-control">
                            <option value="">Assign Later</option>
                            @foreach($staff as $member)
                                <option value="{{ $member->id }}">{{ $member->name }} - {{ $member->accountType ?? 'n/a' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes_create" class="form-label">Notes (Optional)</label>
                        <textarea name="notes" id="notes_create" class="form-control" rows="3" placeholder="Add any relevant notes..."></textarea>
                    </div>
                </div>
                <div class="task-modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateTaskModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Assign Modal Functions
        function openAssignModal(taskId, staffId, status, notes) {
            const modal = document.getElementById('assignModal');
            const form = document.getElementById('assignForm');
            
            form.action = `/admin/assignments/tasks/${taskId}/assign`;
            document.getElementById('staff_id').value = staffId || '';
            document.getElementById('task_status_modal').value = status || 'Pending';
            document.getElementById('notes').value = notes || '';
            
            modal.style.display = 'flex';
        }

        function closeAssignModal() {
            document.getElementById('assignModal').style.display = 'none';
        }

        // Create Task Modal Functions
        function openCreateTaskModal(bookingId) {
            const modal = document.getElementById('createTaskModal');
            const form = document.getElementById('createTaskForm');
            
            form.action = `/admin/assignments/bookings/${bookingId}/tasks`;
            
            // Reset form
            form.reset();
            
            modal.style.display = 'flex';
        }

        function closeCreateTaskModal() {
            document.getElementById('createTaskModal').style.display = 'none';
        }

        // Close modals on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAssignModal();
                closeCreateTaskModal();
            }
        });
    </script>

@endsection

<style>
    .filter-form {
    padding: 0;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    align-items: end;
}

.align-end {
    display: flex;
    gap: 8px;
    align-items: flex-end;
}

/* Booking Card */
.booking-card {
    margin-bottom: 24px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.booking-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.booking-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 16px;
    border-bottom: 2px solid #f3f4f6;
    margin-bottom: 20px;
}

.booking-info {
    flex: 1;
}

.booking-title {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 8px;
}

.booking-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-top: 8px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: #6b7280;
}

.meta-item i {
    color: #9ca3af;
    font-size: 13px;
}

.booking-status-wrapper {
    margin-left: 16px;
}

/* Tasks Section */
.tasks-section {
    margin-top: 20px;
}

.tasks-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.tasks-header h4 {
    font-size: 16px;
    font-weight: 600;
    color: #374151;
    margin: 0;
}

.tasks-table-wrapper {
    overflow-x: auto;
}

.tasks-table {
    min-width: 800px;
}

.tasks-table th {
    background: #f9fafb;
    padding: 12px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
    white-space: nowrap;
}

.tasks-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 14px;
    color: #6b7280;
    vertical-align: middle;
}

.tasks-table tbody tr:hover {
    background: #f9fafb;
}

.tasks-table tbody tr:last-child td {
    border-bottom: none;
}

/* Task Type Badges */
.task-type-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
}

.task-retrieval {
    background: #e0e7ff;
    color: #4338ca;
}

.task-embalming {
    background: #fce7f3;
    color: #be185d;
}

.task-dressing {
    background: #ddd6fe;
    color: #6b21a8;
}

.task-viewing {
    background: #ccfbf1;
    color: #115e59;
}

/* Staff Info */
.staff-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.staff-name {
    font-weight: 500;
    color: #1f2937;
}

.staff-role {
    font-size: 12px;
    color: #9ca3af;
}

.text-muted {
    color: #9ca3af;
    font-style: italic;
}

/* Task Notes */
.task-notes {
    display: block;
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
}

.btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: 1px solid #e5e7eb;
    background: #ffffff;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.15s ease;
    padding: 0;
}

.btn-icon i {
    font-size: 14px;
}

.btn-icon-primary {
    color: #3b82f6;
}

.btn-icon-primary:hover {
    background: #eff6ff;
    border-color: #3b82f6;
}

.btn-icon-danger {
    color: #dc2626;
}

.btn-icon-danger:hover {
    background: #fef2f2;
    border-color: #dc2626;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px 20px;
    color: #9ca3af;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state p {
    margin: 0;
    font-size: 15px;
}

/* Task Modal */
.task-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    animation: fadeIn 0.2s ease forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
    }
}

.task-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    cursor: pointer;
}

.task-modal-content {
    position: relative;
    background: #ffffff;
    border-radius: 12px;
    max-width: 540px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    z-index: 1001;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.task-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 24px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.task-modal-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.modal-close {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: #f3f4f6;
    border-radius: 6px;
    cursor: pointer;
    font-size: 24px;
    color: #6b7280;
    transition: all 0.15s ease;
    padding: 0;
    line-height: 1;
}

.modal-close:hover {
    background: #e5e7eb;
    color: #1f2937;
}

.task-modal-body {
    padding: 24px;
}

.task-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid #e5e7eb;
    background: #f9fafb;
    border-radius: 0 0 12px 12px;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 24px;
    display: flex;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filter-grid {
        grid-template-columns: 1fr;
    }

    .booking-header {
        flex-direction: column;
        gap: 12px;
    }

    .booking-status-wrapper {
        margin-left: 0;
    }

    .booking-meta {
        flex-direction: column;
        gap: 8px;
    }

    .tasks-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .tasks-table-wrapper {
        margin: 0 -1.75rem;
        padding: 0 1.75rem;
    }

    .task-modal-content {
        max-width: 95%;
        margin: 20px;
    }

    .task-modal-header,
    .task-modal-body {
        padding: 20px 16px;
    }

    .task-modal-footer {
        padding: 12px 16px;
        flex-direction: column;
    }

    .task-modal-footer .btn {
        width: 100%;
    }

    .action-buttons {
        flex-direction: column;
        gap: 6px;
    }
}

@media (max-width: 576px) {
    .align-end {
        flex-direction: column;
        align-items: stretch;
    }

    .align-end .btn {
        width: 100%;
    }
}

</style>