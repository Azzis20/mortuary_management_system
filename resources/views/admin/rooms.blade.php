@extends('admin.layouts.app')

@section('title', 'Rooms and Storage')

@section('page-title', 'Rooms and Storage')

@section('content')
    <!-- Add Room Button -->
    <div class="card">
        <div class="card-header">
            <h3>Room Management</h3>
            <button onclick="openModal('addModal')" class="btn btn-primary">Add New Room</button>
        </div>
    </div>

    <!-- Rooms Table -->
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room Type</th>
                    <th>Floor Level</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->room_type }}</td>
                    <td>{{ $room->floor_level }}</td>
                    <td>{{ $room->description ?? 'N/A' }}</td>
                    <td>
                        <button onclick='editRoom(@json($room))' class="btn btn-sm btn-warning">Edit</button>
                        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No rooms found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add Room Modal -->
    <div id="addModal" class="modal" style="display: none;">>
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h3>Add New Room</h3>
            <form action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Room Type</label>
                    <input type="text" name="room_type" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Floor Level</label>
                    <input type="number" name="floor_level" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" onclick="closeModal('addModal')" class="btn btn-secondary">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div id="editModal" class="modal"style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h3>Edit Room</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Room Type</label>
                    <input type="text" name="room_type" id="edit_room_type" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Floor Level</label>
                    <input type="number" name="floor_level" id="edit_floor_level" class="form-control" required min="0">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" onclick="closeModal('editModal')" class="btn btn-secondary">Cancel</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    closeModal('addModal');
    closeModal('editModal');

});
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function editRoom(room) {
        document.getElementById('editForm').action = '/admin/rooms/' + room.id;
        document.getElementById('edit_room_type').value = room.room_type;
        document.getElementById('edit_floor_level').value = room.floor_level;
        document.getElementById('edit_description').value = room.description || '';
        openModal('editModal');
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endpush


