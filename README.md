🎬 AI Cinema Critic - Yapay Zeka Tabanlı Film Duygu Analizi
Bu proje, Derin Öğrenme ve Modern Web Teknolojilerini bir araya getiren hibrit bir yazılım çözümüdür. Kullanıcının bir film hakkında yaptığı İngilizce yorumu analiz eder ve LSTM (Long Short-Term Memory) yapay sinir ağlarını kullanarak yorumun olumlu mu yoksa olumsuz mu olduğunu tespit eder.

🚀 Nasıl Çalışır?
Projede iki ana parça vardır ve bu parçalar birbirleriyle sürekli konuşur:
Beyin (Python & FastAPI): Yapay zeka modelinin yaşadığı yer burasıdır. Yorum gelir, işler, sonucu döndürür. Sadece buna odaklanır, başka bir şeyle ilgilenmez.
Yüz (Laravel): Kullanıcıyla konuşan kısmın adı. Film bilgilerini yönetir, kullanıcıdan yorum alır ve bunu "Beyin"e iletir. Arayüzün tüm sorumluluğu burada.
🔄 İş Akışı
Kullanıcı bir yorum yazer → Laravel arayüz bu yorumu JSON formatında FastAPI sunucusuna gönderir → FastAPI, TensorFlow LSTM modeli aracılığıyla tahmin yapar (0 ile 1 arasında bir skor üretir) → Sonuç geri Laravel'e döndr → Kullanıcı "POSITIVE" ya da "NEGATIVE" yazısını görir.
Kısaca: yorum kutusundan analiz sonucuna kadar her şey otomatik olarak akıyor.

🧠 Teknolojiler ve Kavramlar
Yapay Zeka ve LSTM
Standart bir yazılım "kelimede 'kötü' varsa olumsuz de" diyebilir ama bu yaklaşım kolaylıkla yanılır. Mesela "Film hiç kötü değildi" cümlesi aslında olumludur, ama basit bir kelime eşleştirme bunu yakalamaz.
LSTM burada devreye girer. İnsan beyni gibi cümleyi kelime kelime okuyor ve önceki kelimeleri hatırlıyor. "Değildi" kelimesini gördüğünde, bir önceki "kötü" kelimesinin anlamını tersine çevirdiğini anlıyor. Bu da onu çok daha güçlü bir analiz aracına dönüştürüyor.
Model şu an IMDB veri setindeki binlerce yorum üzerinden eğitilmiş durumda. Kelimelerin birbirine bağlılığını matematiksel olarak öğrenmiş.
API Nedir?
İki farklı yazılımın birbirleriyle konuşmasını sağlayan köprüdür. Bu projede Laravel (PHP) doğrudan Python kodunu çalıştıramaz. Bunun için Python tarafında FastAPI kullanılarak bir endpoint açıldı. Laravel yorumu bu kapıya bırakır, FastAPI sonucu geri verir. Aralarında dil engeli yokmuş gibi.
Laravel
PHP tabanlı, dünyada en çok kullanılan web geliştirme çerçevelerinden biri. Bu projede güvenlik, sayfa yönlendirmeleri, arayüz tasarımı (Blade) ve API ile iletişim gibi her şeyin yönetimi Laravel tarafından sağlanır.

🛠️ Kurulum
Ön Gereksinimler
Python 3.10+, PHP 8.1+ ve Composer, Git olmadan başlamamak en iyisi.
Hızlı Başlangıç (Windows)
Proje klasöründeki baslat.bat dosyasına çift tıklayın. Komut satırı ile uğraşmanız bile gerekmeyecek, her şey otomatik olarak başlatılır ve tarayıcı açılır.
Manuel Kurulum
Eğer daha fazla kontrol istiyorsanız iki terminal açın:
Terminal 1 — AI Sunucusu:
bashcd SentimentAI/src
pip install -r requirements.txt
python -m uvicorn api:app --reload
Terminal 2 — Web Sunucusu:
bashcd SentimentWeb
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --port=8001

📂 Dosya Yapısı
Projenin yapısı oldukça temiz ve mantıklı bir şekilde ayrılmış:
SentimentAI/ — Yapay zeka ile ilgili her şey burada. models/ klasöründe eğitilmiş model dosyaları (.h5 ve .pickle) yaşar. src/api.py modeli dış dünyaya açar, src/train_deep.py ise modelin eğitildiği kaynak koddur.
SentimentWeb/ — Laravel web projesi. SentimentController.php API ile konuşur ve film listesini yönetir. sentiment.blade.php ise kullanıcının gördüğü arayüzün kendisidir.

🎨 Özellikler
Dinamik bir film arşivi var, Wikipedia'dan çekilen yüksek çözünürlüklük posterlerle. Her "Sonraki Film" butonuna basıldığında farklı bir film ekrana geliyor, tekrar eden bir duygu yok.
Tasarım konusunda Tailwind CSS ile yapılmış ve Glassmorphism (buzlu cam) efektleriyle oldukça şık bir görünüm yakalanmış. Yapay zekanın karar verirken ne kadar emin olduğu da yüzdelik olarak canlı gösterildiğinden (örneğin %98.5 güven), sonuçlara güvenebilirsiniz.

📝 Nasıl Kullanılır?
Ekrana bir film gelir, örneğin The Dark Knight. Yorum kutusuna bir şey yazın: "The acting was incredible and the plot was mind-blowing." Analiz Et'e basın ve birkaç saniye içinde yeşil onay kutusuyla birlikte "POSITIVE" sonucu karşınıza çıkar.

⚠️ Not: Model yalnızca İngilizce cümleler üzerinde eğitildi, bu yüzden yorumları İngilizce yazmak gerekir.


Geliştirici: Bor-Code
İletişim: non.mrbora@gmail.com

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

🎬 AI Cinema Critic - Artificial Intelligence-Based Film Sentiment Analysis
This project is a hybrid software solution that combines Deep Learning and Modern Web Technologies. It analyzes the user's English comment about a film and uses LSTM (Long Short-Term Memory) artificial neural networks to determine whether the comment is positive or negative.

🚀 How Does It Work?
There are two main components in the project, and these components constantly communicate with each other:
Brain (Python & FastAPI): This is where the artificial intelligence model resides. It receives comments, processes them, and returns the result. It focuses solely on this and does not concern itself with anything else.
Face (Laravel): This is the part that interacts with the user. It manages movie information, receives comments from the user, and sends them to the “Brain.” It is responsible for the entire interface.
🔄 Workflow
The user writes a comment → The Laravel interface sends this comment to the FastAPI server in JSON format → FastAPI makes a prediction via the TensorFlow LSTM model (produces a score between 0 and 1) → The result is returned to Laravel → The user sees the words “POSITIVE” or “NEGATIVE”.
In short: everything flows automatically, from the comment box to the analysis result.

🧠 Technologies and Concepts
Artificial Intelligence and LSTM
Standard software might say “if the word ‘bad’ is there, it's negative,” but this approach can easily be wrong. For example, the sentence “The movie wasn't bad at all” is actually positive, but simple word matching doesn't catch this.
This is where LSTM comes in. Like the human brain, it reads the sentence word by word and remembers the previous words. When it sees the word “wasn't,” it understands that it reverses the meaning of the previous word “bad.” This makes it a much more powerful analysis tool.
The model is currently trained on thousands of reviews from the IMDB dataset. It has mathematically learned the connections between words.
What is an API?
It is a bridge that allows two different software programs to communicate with each other. In this project, Laravel (PHP) cannot directly execute Python code. For this, an endpoint was opened using FastAPI on the Python side. Laravel sends the review to this endpoint, and FastAPI returns the result. It's as if there were no language barrier between them.
Laravel
One of the most widely used web development frameworks in the world, based on PHP. In this project, Laravel handles everything from security, page redirection, interface design (Blade), and API communication.

🛠️ Installation
Prerequisites
Python 3.10+, PHP 8.1+, and Composer. It's best not to start without Git.
Quick Start (Windows)
Double-click the baslat.bat file in the project folder. You won't even have to deal with the command line; everything starts automatically, and the browser opens.
Manual Installation
If you want more control, open two terminals:
Terminal 1 — AI Server:
bashcd SentimentAI/src
pip install -r requirements.txt
python -m uvicorn api:app --reload
Terminal 2 — Web Server:
bashcd SentimentWeb
composer install
cp .env.example .env
php artisan key:generate
php artisan serve --port=8001

📂 File Structure
The project structure is quite clean and logically separated:
SentimentAI/ — Everything related to artificial intelligence is here. The trained model files (.h5 and .pickle) reside in the models/ folder. src/api.py exposes the model to the outside world, while src/train_deep.py is the source code where the model was trained.
SentimentWeb/ — Laravel web project. SentimentController.php communicates with the API and manages the movie list. sentiment.blade.php is the interface itself that the user sees.

🎨 Features
There is a dynamic movie archive with high-resolution posters pulled from Wikipedia. Each time the “Next Movie” button is clicked, a different movie appears on the screen, with no repeating sentiments.
The design was created using Tailwind CSS and achieved a very stylish look with Glassmorphism (frosted glass) effects. You can trust the results because the AI's confidence level when making decisions is displayed live as a percentage (e.g., 98.5% confidence).

📝 How to Use It?
A movie appears on the screen, for example, The Dark Knight. Write something in the comment box: “The acting was incredible and the plot was mind-blowing.” Press Analyze, and within a few seconds, the result “POSITIVE” appears with a green check mark.

⚠️ Note: The model was trained only on English sentences, so comments must be written in English.


Developer: Bor-Code
Contact: non.mrbora@gmail.com

Translated with DeepL.com (free version)
