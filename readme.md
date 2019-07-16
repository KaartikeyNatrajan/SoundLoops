# SoundLoops

![Loop Creator](https://raw.githubusercontent.com/KaartikeyNatrajan/SoundLoops/screenshots/media/LoopCreation.JPG)

SoundLoops is a web based music creating and sharing application built using Laravel, Vue.js and the JavaScript Web Audio Library.

Users can create custom sound loops using the audio files provided and then publish the loops to the community library for other users to listen to.

#### Personal Collection
![Personal Collection](https://raw.githubusercontent.com/KaartikeyNatrajan/SoundLoops/screenshots/media/PeronalCollection.JPG)

#### Community Library
![Community Library](https://raw.githubusercontent.com/KaartikeyNatrajan/SoundLoops/screenshots/media/CommunityContribution.JPG)

To see a demo : https://raw.githubusercontent.com/KaartikeyNatrajan/SoundLoops/screenshots/media/SoundLoopsDemo.mp4

## Setup Instructions

    git clone https://github.com/KaartikeyNatrajan/SoundLoops.git
    cd SoundLoops/
    cp .env.example .env
    composer install
    php artisan migrate
    php artisan serve

open http://localhost:8000/