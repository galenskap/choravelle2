<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-white text-sm hover:bg-primary-dark focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 hover:shadow-md focus:ring-offset-2 transition-all ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
