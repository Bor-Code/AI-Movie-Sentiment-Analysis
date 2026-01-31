<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Film Eleştirmeni</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="absolute inset-0 z-0">
        <img src="{{ $randomMovie['backdrop'] }}" class="w-full h-full object-cover opacity-40 blur-sm scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
    </div>

    <div class="relative z-10 w-full max-w-4xl bg-gray-800/60 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-700 overflow-hidden flex flex-col md:flex-row">
        
        <div class="md:w-1/3 relative group">
            <img src="{{ $randomMovie['image'] }}" class="w-full h-full object-cover transition transform group-hover:scale-105 duration-500">
            <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black to-transparent">
                <h2 class="text-2xl font-bold text-white drop-shadow-md">{{ $randomMovie['title'] }}</h2>
            </div>
        </div>

        <div class="md:w-2/3 p-8 flex flex-col justify-center">
            
            <div class="mb-6">
                <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 mb-2">
                    Eleştirmen Sensin!
                </h1>
                <p class="text-gray-300 text-sm">Bu film hakkında ne düşünüyorsun? Yapay zeka duygunu analiz etsin.</p>
            </div>

            @if(isset($result))
                <div class="mb-6 p-4 rounded-xl border {{ $result['sentiment'] == 'POSITIVE' ? 'bg-green-500/20 border-green-500' : ($result['sentiment'] == 'NEGATIVE' ? 'bg-red-500/20 border-red-500' : 'bg-gray-500/20 border-gray-500') }} animate-pulse">
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold {{ $result['sentiment'] == 'POSITIVE' ? 'text-green-400' : ($result['sentiment'] == 'NEGATIVE' ? 'text-red-400' : 'text-gray-400') }}">
                            @if($result['sentiment'] == 'POSITIVE') <i class="fas fa-smile-beam mr-2"></i> BEĞENDİN
                            @elseif($result['sentiment'] == 'NEGATIVE') <i class="fas fa-angry mr-2"></i> BEĞENMEDİN
                            @else <i class="fas fa-meh mr-2"></i> KARARSIZ
                            @endif
                        </span>
                        <span class="text-xs bg-black/30 px-2 py-1 rounded">Güven: %{{ number_format($result['score'] * 100, 1) }}</span>
                    </div>
                </div>
                
                <a href="/" class="block w-full text-center py-3 mb-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-semibold transition">
                    <i class="fas fa-random mr-2"></i> Başka Film Getir
                </a>
            @endif

            @if(!isset($result))
            <form action="{{ route('analyze') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $randomMovie['id'] }}">
                
                <div class="relative">
                    <textarea name="review" rows="4" class="w-full p-4 bg-gray-900/50 border border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-white placeholder-gray-500 transition resize-none" placeholder="Yorumunu İngilizce yaz... (Örn: The acting was incredible)"></textarea>
                    <div class="absolute bottom-3 right-3 text-gray-500 text-xs">
                        <i class="fas fa-language"></i> EN
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl font-bold shadow-lg shadow-purple-900/30 transition transform hover:-translate-y-1">
                    Analiz Et <i class="fas fa-magic ml-2"></i>
                </button>
            </form>
            @endif

            @if(session('error'))
                <div class="mt-4 p-3 bg-red-900/50 text-red-200 text-sm rounded-lg border border-red-800">
                    {{ session('error') }}
                </div>
            @endif

        </div>
    </div>

</body>
</html>