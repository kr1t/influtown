<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Helpers\LineBot;
use Helpers\LineLiff;

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


                        if ($text == '#ค้นหา') {
                            return $this->findInfluencer();
                        } else if ($text == '#เลือกหมวด') {
                            return $this->findInfluencer(false);
                        } else if ($text == 'ค้นหา#เพศ') {
                            return $this->selectGender();
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

                    ]
                ]
            ],

        ])
            ->reply();
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
                                "label" => "<18",
                                "text" => "gender#ชาย"
                            ],
                            "margin" => "lg",
                            "style" => "primary"
                        ],
                        [
                            "type" => "button",
                            "action" => [
                                "type" => "message",
                                "label" => "18-23",
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

                    ]
                ]
            ],

        ])
            ->reply();
    }

    public function test()
    {
        $bot = $this->bot->setUser('U9dbcc5b44c3f15d67f4ab2de4b0aac2a');


        return $bot->getUser();
    }
}