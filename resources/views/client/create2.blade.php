<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title> Client informations</title>
</head>

<body class="bg-gray-100 p-8">
    <form class="space-y-4">
        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-6">GENERAL DETAILS</h2>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Business Structure</label>
                <input type="text" id="name" name="name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label for="client_type" class="block text-sm font-medium text-gray-700">Client Type</label>
                <input type="text" id="client_type" name="client_type"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label for="full_legal_name" class="block text-sm font-medium text-gray-700">Full Legal Name</label>
                <input type="text" id="full_legal_name" name="full_legal_name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

        </div>

        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-6">CONTACT DETAILS</h2>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="name" name="name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" name="email"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-6">TAX & COMPANY DETAILS</h2>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="name" name="name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" name="email"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>

        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-6">BANK DETAILS</h2>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" id="name" name="name"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email"
                    class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" name="email"
                        class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>
        <div class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <button type="submit"
                class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue active:bg-blue-800">
                Submit
            </button>
        </div>
    </form>
</body>

</html>
