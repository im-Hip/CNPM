<!DOCTYPE html>
<html>
<head>
    <title>Create Notification</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl mb-4">Create Notification</h1>
        
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">{{ session('error') }}</div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('notifications.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" class="mt-1 block w-full border-gray-300 rounded-md @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md @error('type') border-red-500 @enderror" required>
                    <option value="exam" {{ old('type') == 'exam' ? 'selected' : '' }}>Exam</option>
                    <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                    <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                    <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="scholarship" {{ old('type') == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="recipient_type" class="block text-sm font-medium text-gray-700">Recipient Type</label>
                <select name="recipient_type" id="recipient_type" class="mt-1 block w-full border-gray-300 rounded-md @error('recipient_type') border-red-500 @enderror" required onchange="toggleRecipientField()">
                    @if (Auth::user()->role === 'admin')
                        <option value="all" {{ old('recipient_type') == 'all' ? 'selected' : '' }}>All (Teachers & Students)</option>
                        <option value="teachers" {{ old('recipient_type') == 'teachers' ? 'selected' : '' }}>Teachers</option>
                        <option value="students" {{ old('recipient_type') == 'students' ? 'selected' : '' }}>Students</option>
                        <option value="class" {{ old('recipient_type') == 'class' ? 'selected' : '' }}>Class</option>
                        <option value="individual" {{ old('recipient_type') == 'individual' ? 'selected' : '' }}>Individual</option>
                    @elseif (Auth::user()->role === 'teacher')
                        <option value="class" {{ old('recipient_type') == 'class' ? 'selected' : '' }}>Class</option>
                    @endif
                </select>
                @error('recipient_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div id="recipient_field" class="mb-4" style="display: none;">
                <label for="recipient_id" class="block text-sm font-medium text-gray-700">Recipient</label>
                <div id="class_select" class="mb-2" style="display: none;">
                    <select name="recipient_id" id="recipient_id_class" class="mt-1 block w-full border-gray-300 rounded-md @error('recipient_id') border-red-500 @enderror">
                        @foreach ($classes as $class)
                            @if ($class)
                                <option value="{{ $class->id }}" {{ old('recipient_id') == $class->id ? 'selected' : '' }}>Class {{ $class->name ?? $class->id }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('recipient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- CHỈ HIỂN THỊ INDIVIDUAL CHO ADMIN --}}
                @if (Auth::user()->role === 'admin')
                <div id="individual_search" class="mb-2" style="display: none;">
                    <input type="text" id="recipient_search" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Search by email..." oninput="searchRecipient()">
                    <input type="hidden" name="recipient_id" id="recipient_id_individual">
                    <div id="suggestions" class="border border-gray-300 rounded-md mt-1 max-h-40 overflow-y-auto" style="display: none;"></div>
                </div>
                @endif
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Send</button>
        </form>
    </div>

    <script>
        let previousType = '';

        function toggleRecipientField() {
            const recipientType = document.getElementById('recipient_type').value;
            const recipientField = document.getElementById('recipient_field');
            const classSelect = document.getElementById('class_select');
            const individualSearch = document.getElementById('individual_search');
            const classSelectElement = document.getElementById('recipient_id_class');
            const individualHidden = document.getElementById('recipient_id_individual');

            if (recipientType === 'all' || recipientType === 'teachers' || recipientType === 'students') {
                recipientField.style.display = 'none';
                classSelect.style.display = 'none';
                if (individualSearch) individualSearch.style.display = 'none';
            } else {
                recipientField.style.display = 'block';
                if (recipientType === 'class') {
                    classSelect.style.display = 'block';
                    if (individualSearch) individualSearch.style.display = 'none';
                    if (previousType === 'individual' && individualHidden) {
                        individualHidden.value = '';
                    }
                } else if (recipientType === 'individual') {
                    classSelect.style.display = 'none';
                    if (individualSearch) individualSearch.style.display = 'block';
                    if (previousType === 'class' && classSelectElement) {
                        classSelectElement.value = '';
                    }
                    if (individualHidden) {
                        individualHidden.value = '';
                    }
                    document.getElementById('recipient_search').value = '';
                    document.getElementById('suggestions').style.display = 'none';
                }
            }
            previousType = recipientType;
            console.log('Toggled to:', recipientType, 'Class value:', classSelectElement ? classSelectElement.value : 'N/A');
        }

        function searchRecipient() {
            const search = document.getElementById('recipient_search').value;
            if (search.length < 2) {
                document.getElementById('suggestions').style.display = 'none';
                return;
            }
            const suggestions = document.getElementById('suggestions');
            suggestions.style.display = 'block';
            suggestions.innerHTML = 'Loading...';

            axios.get('/search-recipients', {
                params: { search: search }
            }).then(response => {
                suggestions.innerHTML = '';
                response.data.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('p-2', 'cursor-pointer', 'hover:bg-gray-200');
                    div.textContent = item.email;
                    div.onclick = function () {
                        document.getElementById('recipient_search').value = item.email;
                        document.getElementById('recipient_id_individual').value = item.id;
                        suggestions.style.display = 'none';
                    };
                    suggestions.appendChild(div);
                });
                if (response.data.length === 0) suggestions.innerHTML = 'No results';
            }).catch(error => {
                suggestions.innerHTML = 'Error loading results';
            });
        }

        // XÓA DEBUG SUBMIT (KHÔNG CẦN NỮA)
        // document.querySelector('form').addEventListener('submit', function(e) { ... });

        toggleRecipientField();
    </script>
</body>
</html>