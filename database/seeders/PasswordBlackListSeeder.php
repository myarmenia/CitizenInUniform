<?php

namespace Database\Seeders;

use App\Models\PasswordBlackList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasswordBlackListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list = [
            '12345',
            '55555',
            '101010',
            '112233',
            '159753',
            '232323',
            '987654',
            '999999',
            '8675309',
            '987654321',
            '1234qwer',
            '1q2w3e4r',
            '1q2w3e4r5t',
            '1qaz2wsx',
            'access',
            'adidas',
            'admin',
            'alexis',
            'amanda',
            'andrew',
            'angel',
            'angela',
            'angels',
            'anthony',
            'apples',
            'arsenal',
            'asdfasdf',
            'asdfgh',
            'asdfghjkl',
            'ashley',
            'austin',
            'azerty',
            'badboy',
            'bailey',
            'banana',
            'bandit',
            'barney',
            'baseball',
            'batman',
            'benjamin',
            'bigdaddy',
            'bigdog',
            'biteme',
            'black',
            'bond007',
            'bonnie',
            'booboo',
            'booger',
            'boomer',
            'boston',
            'brandon',
            'brandy',
            'bulldog', 'buster', 'butter', 'camaro', 'cameron', 'canada', 'captain', 'carlos', 'casper', 'charles', 'cheese', 'chelsea', 'chester', 'chicago', 'chicken', 'cocacola', 'coffee', 'compaq', 'computer', 'cookie', 'cooper', 'corvette', 'cowboy', 'cowboys', 'crystal', 'dakota', 'dallas', 'daniel', 'danielle', 'david', 'debbie', 'dennis', 'dexter', 'diablo', 'diamond', 'doctor', 'dolphin', 'dragon', 'driver', 'eagles', 'elephant', 'enter', 'falcon', 'fender', 'ferrari', 'fishing', 'florida', 'flower', 'football', 'forever', 'freedom', 'gandalf', 'gateway', 'gators', 'gemini', 'gfhjkm', 'ghbdtn', 'giants', 'ginger', 'golden', 'golfer', 'guitar', 'hammer', 'hannah', 'hardcore', 'harley', 'heather', 'hello', 'helpme', 'hockey', 'hotdog', 'hunter', 'iceman', 'iloveyou', 'internet', 'jackass', 'jackie', 'jackson', 'jaguar', 'james', 'jasper', 'jennifer', 'jeremy', 'jesus', 'jordan', 'joshua', 'junior', 'justin', 'killer', 'klaster', 'knight', 'lakers', 'letmein', 'liverpoo', 'liverpool', 'london', 'lovely', 'lovers', 'lucky', 'maddog', 'maggie', 'marina', 'marlboro', 'martin', 'master', 'matrix', 'maverick', 'maxwell', 'mercedes', 'merlin', 'metallic', 'michael', 'mickey', 'midnight', 'miller', 'money', 'monica', 'monkey', 'monster', 'morgan', 'mother', 'mountain', 'muffin', 'murphy', 'mustang', 'nascar', 'ncc1701', 'newyork', 'nicholas', 'nicole', 'nikita', 'ninja', 'nirvana', 'oliver', 'orange', 'packers', 'panther', 'panties', 'password', 'patrick', 'peaches', 'peanut', 'pepper', 'phoenix', 'player', 'please', 'pokemon', 'pookie', 'porsche', 'prince', 'princess', 'purple', 'q1w2e3', 'q1w2e3r4', 'q1w2e3r4t5', 'qazwsx', 'qazwsxedc', 'qazxsw', 'qwaszx', 'qwer1234', 'qwerty', 'rabbit', 'raiders', 'rainbow', 'ranger', 'rangers', 'redskins', 'redsox', 'richard', 'robot', 'rocket', 'rosebud', 'samantha', 'samson', 'samsung', 'scooby', 'scooter', 'scorpio', 'scorpion', 'secret', 'shadow', 'shannon', 'sierra', 'silver', 'slayer', 'slipknot', 'smokey', 'snoopy', 'soccer', 'sophie', 'spanky', 'sparky', 'spider', 'startrek', 'starwars', 'steelers', 'stupid', 'success', 'summer', 'sunshine', 'superman', 'taylor', 'tennis', 'theman', 'thunder', 'thx1138', 'tiffany', 'tiger', 'tigger', 'toyota', 'trust', 'tucker', 'turtle', 'united', 'user', 'victor', 'victoria', 'viking', 'voodoo', 'warrior', 'welcome', 'westcoast', 'whatever', 'william', 'willie', 'winner', 'winston', 'winter', 'wizard', 'yamaha', 'yankees', 'yellow', 'zxcvbn', 'zxcvbnm'
        ];

        foreach ($list as $pass) {
            PasswordBlackList::updateOrCreate(['password' => $pass]);
        }
    }
}
