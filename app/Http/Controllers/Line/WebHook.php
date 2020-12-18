<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helpers\LineBot;
use Helpers\LineLiff;
use App\Influencer;

class WebHook extends Controller
{
    private $bot;

    public function __construct()
    {
        $this->bot = new LineBot(env('LINE_MESSAGING_TOKEN'));
        $this->liff = new LineLiff();
    }

    public function index(Request $request)
    {
        try {

            if ($request['events']) {
                if (sizeof($request['events']) > 0) {
                    foreach ($request['events'] as $event) {
                        $reply_token = $event['replyToken'];
                        $text = isset($event['message']['text']) ? $event['message']['text'] : '';
                        $userID = $event['source']['userId'];

                        $this->bot->setReplyToken($reply_token);
                        $this->bot->setUser($userID);

                        // if ($userID != 'U2d9ef70b54f10f49329660b214bc1196') {
                        //     return $this->bot->addText('ขออภัยขณะนี้กำลังปรับปรุง server')->addtext($userID)->reply();
                        // }

                        $checkRegister = $this->checkRegister($userID);

                        if ($checkRegister != true) {
                            return $this->sendRegisterImage();
                        }
                        // หากไม่มีการลงทะเบียนจะยืงการ์ดให้ลงทะเบียน



                        $user = $this->bot->getUser();

                        if ($text == '#ความรู้') {
                            return $this->bot->addImage(['https://i.imgur.com/cz8NWqc.jpg', 'https://i.imgur.com/uSlmrkP.jpg', 'https://i.imgur.com/kLz78K7.jpg', 'https://i.imgur.com/kLz78K7.jpg', 'https://i.imgur.com/ShnDkwu.jpg'])->reply();
                        }

                        $textexplode = explode("#", $text);




                        if ($text == '#ค้นหา') {
                            return $this->findInfluencer();
                        }
                        if ($text == '#เลือกหมวด') {
                            return $this->findInfluencer(false);
                        }
                        if ($text == 'ค้นหา#เพศ') {
                            return $this->selectGender();
                        }
                        if ($text == 'ค้นหา#อายุ') {
                            return $this->selectAge();
                        }
                        if ($text == 'ค้นหา#ความถนัด') {
                            return $this->selectType();
                        }
                        if ($text == 'ค้นหา#follower') {
                            return $this->selectFollower();
                        }

                        if ($text == '#ค้นหาเลย') {
                            return $this->searchInfluencer();
                        }
                        if ($textexplode[0] == 'เพศ') {
                            return $this->setGender($textexplode[1]);
                        }
                        if ($textexplode[0] == 'อายุ') {
                            return $this->setAge($textexplode[1]);
                        }
                        if ($textexplode[0] == 'ความถนัด') {
                            return $this->setType($textexplode[1]);
                        }
                        if ($textexplode[0] == 'Follower') {
                            return $this->setFollower($textexplode[1]);
                        }
                        return [
                            'status' => 200,
                        ];

                        // END LOGIC FROM REPLY MESSAGE //

                    }
                }
            }

            return 'NOBOT';
        } catch (\Exception $e) {
        }
    }

    public function checkRegister()
    {
        $find = $this->bot->getUser();
        $isRegistered = $find ? true : false;
        return $isRegistered;
    }

    public function influCard($data)
    {
        return [
            "type" => "bubble",
            "hero" => [
                "type" => "image",
                "url" => $data['profile_url'],
                "size" => "full",
                "aspectRatio" => "20:13",
                "aspectMode" => "cover",

            ],
            "body" => [
                "type" => "box",
                "layout" => "vertical",
                "contents" => [
                    [
                        "type" => "text",
                        "text" => $data['full_name'],
                        "weight" => "bold",
                        "size" => "xl",
                        "contents" => []
                    ],
                    [
                        "type" => "box",
                        "layout" => "vertical",
                        "spacing" => "sm",
                        "margin" => "lg",
                        "contents" => [
                            [
                                "type" => "box",
                                "layout" => "baseline",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "text",
                                        "text" => "เพศ",
                                        "size" => "sm",
                                        "color" => "#AAAAAA",
                                        "flex" => 3,
                                    ],
                                    [
                                        "type" => "text",
                                        "text" => $data['gender_text'],
                                        "size" => "sm",
                                        "color" => "#666666",
                                        "flex" => 5,
                                        "wrap" => true,
                                    ]
                                ]
                            ],
                            [
                                "type" => "box",
                                "layout" => "baseline",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "text",
                                        "text" => "ช่วงอายุ",
                                        "size" => "sm",
                                        "color" => "#AAAAAA",
                                        "flex" => 3,
                                    ],
                                    [
                                        "type" => "text",
                                        "text" => $data['age_text'],
                                        "size" => "sm",
                                        "color" => "#666666",
                                        "flex" => 5,
                                        "wrap" => true,
                                    ]
                                ]
                            ],
                            [
                                "type" => "box",
                                "layout" => "baseline",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "text",
                                        "text" => "บัดเจ้ด",
                                        "size" => "sm",
                                        "color" => "#AAAAAA",
                                        "flex" => 3,
                                    ],
                                    [
                                        "type" => "text",
                                        "text" => "" . $data['budget'],
                                        "size" => "sm",
                                        "color" => "#666666",
                                        "flex" => 5,
                                        "wrap" => true,
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "footer" => [
                "type" => "box",
                "layout" => "vertical",
                "flex" => 0,
                "spacing" => "sm",
                "contents" => [
                    [
                        "type" => "button",
                        "action" => [
                            "type" => "uri",
                            "label" => "ดูข้อมูล",
                            "uri" => "https://liff.line.me/1655241745-ZpdPpxdk?id={$data['id']}"
                        ],
                        "color" => "#FF6600FF",
                        "height" => "sm",
                        "style" => "primary"
                    ],
                    [
                        "type" => "spacer",
                        "size" => "sm"
                    ]
                ]
            ]
        ];
    }
    public function searchInfluencer()
    {
        $bot = $this->bot->setUser('U9dbcc5b44c3f15d67f4ab2de4b0aac2a');

        $user = $this->bot->getUser();
        $search = Influencer::where('gender', $user->s_gender)->where('age', $user->s_age)->where('follow', $user->s_follow)->get();

        if (count($search) < 1) {
            return $this->bot->addText('ไม่พบอินฟลูเอนเซอร์')->reply();
        }
        $cards = [];

        foreach ($search as $influ) {
            $influ->profile_url = url($influ->profile_url);
            array_push($cards,  $this->influCard($influ));
        }

        return
            $this->bot->addCarousel('influ', $cards)->reply();
    }
    public function sendRegisterImage()
    {
        return $this->bot->addText('กรุณาทำการลงทะเบียนก่อนใช้งานฟังชันดังกล่าว')
            ->addImageURI(
                'กรุณาทำการลงทะเบียนก่อนใช้งานฟังชันดังกล่าว',
                'https://i.imgur.com/1tgleaL.jpg',
                $this->liff->get('register'),
                1040,
                1040
            )->reply();
    }

    public function findInfluencer($clearData = true)
    {
        $user = $this->bot->getUser();

        if ($clearData) {
            $user->update([
                's_gender' => null,
                's_age' => null,
                's_type' => null,
                's_follow' => null
            ]);
        }

        return $this->bot->addCarousel('กรุณาทำการลงทะเบียนก่อนใช้งานฟังชันดังกล่าว', [
            [
                "type" => "bubble",
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "spacing" => "md",

                    "contents" => [
                        [
                            "type" => "text",
                            "text" => "กรุณาเลือกหมวด",
                            "weight" => "bold",
                            "size" => "xl",
                            "contents" => []
                        ],
                        [
                            "type" => "text",
                            "text" => "Sauce, Onions, Pickles, Lettuce & Cheese",
                            "size" => "xxs",
                            "color" => "#AAAAAA",
                            "wrap" => true,
                            "contents" => []
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เพศ",
                                "text" => "ค้นหา#เพศ"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "อายุ",
                                "text" => "ค้นหา#อายุ"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ความถนัด",
                                "text" => "ค้นหา#ความถนัด"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ยอด Follower",
                                "text" => "ค้นหา#follower"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ค้นหาเลย",
                                "text" => "#ค้นหาเลย"
                            ],
                            "color" => "#FF8600FF",
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                    ]
                ]
            ],

        ])
            ->reply();
    }


    public function selectGender()
    {
        return $this->bot->addCarousel('กรุณาทำการลงทะเบียนก่อนใช้งานฟังชันดังกล่าว', [
            [
                "type" => "bubble",
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "spacing" => "md",

                    "contents" => [
                        [
                            "type" => "text",
                            "text" => "กรุณาเลือกเพศ",
                            "weight" => "bold",
                            "size" => "xl",
                            "contents" => []
                        ],
                        [
                            "type" => "text",
                            "text" => "Sauce, Onions, Pickles, Lettuce & Cheese",
                            "size" => "xxs",
                            "color" => "#AAAAAA",
                            "wrap" => true,
                            "contents" => []
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เพศชาย",
                                "text" => "เพศ#ชาย"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เพศหญิง",
                                "text" => "เพศ#หญิง"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เพศ LGBT",
                                "text" => "เพศ#lgbt"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],



                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เลือกหมวดอิ่น",
                                "text" => "#เลือกหมวด"
                            ],
                            "color" => "#FF8600FF",
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ค้นหาเลย",
                                "text" => "#ค้นหาเลย"
                            ],
                            "color" => "#2554C7",
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                    ]
                ]
            ],

        ])
            ->reply();
    }



    public function setGender($gender)
    {
        $g = '';
        switch ($gender) {
            case 'ชาย';
                $g = 'M';
                break;

            case 'หญิง';
                $g = 'F';
                break;

            case 'lgbt';
                $g = 'L';
                break;
        }

        $user = $this->bot->getUser();
        $user->update([
            's_gender' => $g
        ]);

        return $this->selectAge();
    }


    public function setAge($age)
    {

        $a = '';
        switch ($age) {
            case 'ต่ำกว่า18';
                $a = 1;
                break;
            case '18-23';
                $a = 2;
                break;
            case '24-27';
                $a = 3;
                break;
            case '28-30';
                $a = 4;
                break;
            case '30ขึ้นไป';
                $a = 5;
                break;
        }

        $user = $this->bot->getUser();
        $user->update([
            's_age' => $a
        ]);
        return $this->selectType();
    }

    public function setType($type)
    {

        $a = '';
        switch ($type) {
            case 'เสื้อผ้าและกีฬา';
                $a = 1;
                break;
            case 'เครื่องสำอางค์';
                $a = 2;
                break;
            case 'อาหาร';
                $a = 3;
                break;
            case 'ท่องเที่ยว';
                $a = 4;
                break;
            case 'เทคโนโลยี';
                $a = 5;
                break;
        }

        $user = $this->bot->getUser();
        $user->update([
            's_type' => $a
        ]);
        return $this->selectFollower();
    }
    public function setFollower($type)
    {

        $a = '';
        switch ($type) {
            case 'ต่ำกว่า1000';
                $a = 1;
                break;
            case '1000-10,000';
                $a = 2;
                break;
            case '10,001-50,000';
                $a = 3;
                break;
            case '50,001-100,000';
                $a = 4;
                break;
            case '100,001-1,000,000';
                $a = 5;
                break;
            case '1,000,000ขึ้นไป';
                $a = 6;
                break;
        }

        $user = $this->bot->getUser();
        $user->update([
            's_follow' => $a
        ]);
        return $this->searchInfluencer();
    }

    public function selectAge()
    {
        return $this->bot->addCarousel('กรุณาทำการลงทะเบียนก่อนใช้งานฟังชันดังกล่าว', [
            [
                "type" => "bubble",
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "spacing" => "md",

                    "contents" => [
                        [
                            "type" => "text",
                            "text" => "กรุณาเลือกอายุ",
                            "weight" => "bold",
                            "size" => "xl",
                            "contents" => []
                        ],
                        [
                            "type" => "text",
                            "text" => "Sauce, Onions, Pickles, Lettuce & Cheese",
                            "size" => "xxs",
                            "color" => "#AAAAAA",
                            "wrap" => true,
                            "contents" => []
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ต่ำกว่า 18",
                                "text" => "อายุ#ต่ำกว่า18"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "18-23",
                                "text" => "อายุ#18-23"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "24-27",
                                "text" => "อายุ#24-27"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "28-30",
                                "text" => "อายุ#28-30"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "30 ขึ้นไป",
                                "text" => "อายุ#30ขึ้นไป"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],



                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เลือกหมวดอิ่น",
                                "text" => "#เลือกหมวด"
                            ],
                            "color" => "#FF8600FF",
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ค้นหาเลย",
                                "text" => "#ค้นหาเลย"
                            ],
                            "color" => "#2554C7",
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                    ]
                ]
            ],

        ])
            ->reply();
    }

    public function selectType()
    {
        return $this->bot->addCarousel('กรุณาทำการลงทะเบียนก่อนใช้งานฟังชันดังกล่าว', [
            [
                "type" => "bubble",
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "spacing" => "md",

                    "contents" => [
                        [
                            "type" => "text",
                            "text" => "กรุณาเลือกความถนัดของอินฟลูเอนเซอร์",
                            "weight" => "bold",
                            "size" => "xl",
                            "contents" => []
                        ],
                        [
                            "type" => "text",
                            "text" => "Sauce, Onions, Pickles, Lettuce & Cheese",
                            "size" => "xxs",
                            "color" => "#AAAAAA",
                            "wrap" => true,
                            "contents" => []
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เสื้อผ้าและกีฬา",
                                "text" => "ความถนัด#เสื้อผ้าและกีฬา"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เครื่องสำอางค์",
                                "text" => "ความถนัด#เครื่องสำอางค์"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "อาหาร",
                                "text" => "ความถนัด#อาหาร"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],



                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ท่องเที่ยว",
                                "text" => "ความถนัด#ท่องเที่ยว"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เทคโนโลยี แก็ดเจ็ด เกม",
                                "text" => "ความถนัด#เทคโนโลยี"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เลือกหมวดอิ่น",
                                "text" => "#เลือกหมวด"
                            ],
                            "color" => "#FF8600FF",
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ค้นหาเลย",
                                "text" => "#ค้นหาเลย"
                            ],
                            "color" => "#2554C7",
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                    ]
                ]
            ],

        ])
            ->reply();
    }

    public function selectFollower()
    {
        return $this->bot->addCarousel('กรุณาทำการลงทะเบียนก่อนใช้งานฟังชันดังกล่าว', [
            [
                "type" => "bubble",
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "spacing" => "md",

                    "contents" => [
                        [
                            "type" => "text",
                            "text" => "กรุณาเลือกยอดผู้ติดตามของอินฟลูเอนเซอร์",
                            "weight" => "bold",
                            "size" => "xl",
                            "contents" => []
                        ],
                        [
                            "type" => "text",
                            "text" => "Sauce, Onions, Pickles, Lettuce & Cheese",
                            "size" => "xxs",
                            "color" => "#AAAAAA",
                            "wrap" => true,
                            "contents" => []
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ต่ำกว่า 1000",
                                "text" => "Follower#ต่ำกว่า1000"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "1000-10,000",
                                "text" => "Follower#1000-10,000"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "10,001-50,000",
                                "text" => "Follower#10,001-50,000"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],



                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "50,001-100,000",
                                "text" => "Follower#50,001-100,000"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "100,001-1,000,000",
                                "text" => "Follower#100,001-1,000,000"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "1,000,000 ขึ้นไป",
                                "text" => "Follower#1,000,000ขึ้นไป"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "เลือกหมวดอิ่น",
                                "text" => "#เลือกหมวด"
                            ],
                            "color" => "#FF8600FF",
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "ค้นหาเลย",
                                "text" => "#ค้นหาเลย"
                            ],
                            "color" => "#2554C7",
                            "margin" => "lg",
                            "style" => "primary"
                        ],

                    ]
                ]
            ],

        ])
            ->reply();
    }


    public function test()
    {
        $bot = $this->bot->setUser('U9dbcc5b44c3f15d67f4ab2de4b0aac2a');

        $user = $this->bot->getUser();
        $search = Influencer::where('gender', $user->s_gender)->get();
        $cards = [];

        foreach ($search as $influ) {
            $influ->profile_url = url($influ->profile_url);
            array_push($cards,  $this->influCard($influ));
        }

        return
            $this->bot->addCarousel('influ', $cards)->push();
    }
}