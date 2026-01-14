<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\CompanyDetail;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageSectionController extends Controller
{

    public function pageSections()
{
    $title = 'Page Sections';
    $hero = PageSection::where('page_id', 1)->where('section', 'hero')->get();
    $finance = PageSection::where('page_id', 1)->where('section', 'finance')->get();
    $counter = PageSection::where('page_id', 1)->where('section', 'counter')->get();
    
    $extraimages = PageSection::where('page_id', 1)
    ->where('section', 'extraimages')
    ->get();


    

    
    for ($i = 1; $i <= 4; $i++) {
        $essentialRecords = [
            [
                'page_id' => 1,
                'section' => 'essentials',
                'name' => "card_image_$i",
                'type' => 'image',
                'value' => ''
            ],
            [
                'page_id' => 1,
                'section' => 'essentials',
                'name' => "card_title_text_$i",
                'type' => 'text',
                'value' => ''
            ],
            [
                'page_id' => 1,
                'section' => 'essentials',
                'name' => "card_desc_text_$i",
                'type' => 'text',
                'value' => ''
            ],
            [
                'page_id' => 1,
                'section' => 'essentials',
                'name' => "card_link_$i",
                'type' => 'text',
                'value' => ''
            ]
        ];

        foreach ($essentialRecords as $record) {
            PageSection::firstOrCreate(
                [
                    'page_id' => $record['page_id'],
                    'section' => $record['section'],
                    'name' => $record['name']
                ],
                $record
            );
        }
    }

    $essentials = PageSection::where('page_id', 1)->where('section', 'essentials')->get();

    return view('/page_sections/index', compact('title', 'hero', 'finance', 'counter','extraimages', 'essentials'));
}
           


    public function update(Request $request, $section)
    {
        if ($section === 'hero') {
            $request->validate([
                'hero_main_image' => 'nullable|image|mimes:jpg,jpeg,png',
                'hero_primary_text' => 'nullable|string|max:255',
                'hero_secondary_text' => 'nullable|string',
                'hero_button_link' => 'nullable|string',
            ]);

            if ($request->hasFile('hero_main_image')) {
                $mainImage = $request->file('hero_main_image');
                $imageName = time() . '_' . $mainImage->getClientOriginalName();
                $mainImage->move(public_path('images/page_sections'), $imageName);

                PageSection::where('id', $request->hero_main_image_id)->update(['value' => $imageName]);
            }

            PageSection::where('id', $request->hero_primary_text_id)->update(['value' => $request->hero_primary_text]);

            PageSection::where('id', $request->hero_secondary_text_id)->update(['value' => $request->hero_secondary_text]);
            PageSection::where('id', $request->hero_button_link_id)->update(['value' => $request->hero_button_link]);

            return redirect()->back()->with('success', 'Hero section updated successfully!');
        }
        elseif ($section === 'finance') {
            $request->validate([
                'finance_image_1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'finance_image_2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'finance_primary_text' => 'required|string|max:255',
                'finance_secondary_text' => 'nullable|string',
                'finance_button_link' => 'nullable|string',
            ]);

            if ($request->hasFile('finance_image_1')) {
                $image1 = $request->file('finance_image_1');
                $image1Name = time() . '_1_' . $image1->getClientOriginalName();
                $image1->move(public_path('images/page_sections'), $image1Name);

                PageSection::where('id', $request->finance_image_1_id)
                    ->update(['value' => $image1Name]);
            }

            
            if ($request->hasFile('finance_image_2')) {
                $image2 = $request->file('finance_image_2');
                $image2Name = time() . '_2_' . $image2->getClientOriginalName();
                $image2->move(public_path('images/page_sections'), $image2Name);

                PageSection::where('id', $request->finance_image_2_id)
                    ->update(['value' => $image2Name]);
            }

            PageSection::where('id', $request->finance_primary_text_id)
                ->update(['value' => $request->finance_primary_text]);

            PageSection::where('id', $request->finance_secondary_text_id)
                ->update(['value' => $request->finance_secondary_text]);

            PageSection::where('id', $request->finance_button_link_id)
                ->update(['value' => $request->finance_button_link]);

            return redirect()->back()->with('success', 'Finance section updated successfully!');
        }
        elseif ($section === 'extraimages') {
            $request->validate([
                'forum_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'login_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'signup_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
               
            ]);

            if ($request->hasFile('forum_image')) {
                $image1 = $request->file('forum_image');
                $image1Name = time() . '_1_' . $image1->getClientOriginalName();
                $image1->move(public_path('images/page_sections'), $image1Name);

                PageSection::where('id', $request->forum_image_id)
                    ->update(['value' => $image1Name]);
            }
            if ($request->hasFile('login_image')) {
                $image2 = $request->file('login_image');
                $image2Name = time() . '_2_' . $image2->getClientOriginalName();
                $image2->move(public_path('images/page_sections'), $image2Name);
            
                PageSection::where('section', 'extraimages')
                    ->where('name', 'login_image')  
                    ->update(['value' => $image2Name]);
            }
            
            if ($request->hasFile('signup_image')) {
                $image3 = $request->file('signup_image');
                $image3Name = time() . '_3_' . $image3->getClientOriginalName();
                $image3->move(public_path('images/page_sections'), $image3Name);
            
                PageSection::where('section', 'extraimages')
                    ->where('name', 'signup_image')  
                    ->update(['value' => $image3Name]);
            }

            

          

            return redirect()->back()->with('success', 'Finance section updated successfully!');
        }
        elseif ($section === 'essentials') {
            
            $request->validate([
                'card_image_1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'card_image_2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'card_image_3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'card_image_4' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'card_title_text_1' => 'required|string|max:255',
                'card_title_text_2' => 'required|string|max:255',
                'card_title_text_3' => 'required|string|max:255',
                'card_title_text_4' => 'required|string|max:255',
                'card_desc_text_1' => 'required|string|max:255',
                'card_desc_text_2' => 'required|string|max:255',
                'card_desc_text_3' => 'required|string|max:255',
                'card_desc_text_4' => 'required|string|max:255',
                'card_link_1' => 'required|string|max:255',
                'card_link_2' => 'required|string|max:255',
                'card_link_3' => 'required|string|max:255',
                'card_link_4' => 'required|string|max:255',
            ]);
        
            try {
                
                foreach (range(1, 4) as $i) {
                    if ($request->hasFile("card_image_$i")) {
                        $image = $request->file("card_image_$i");
                        $imageName = time() . '_' . $i . '_' . $image->getClientOriginalName();
                        $image->move(public_path('images/page_sections'), $imageName);
        
                        PageSection::where('id', $request->input("card_image_{$i}_id"))
                            ->update(['value' => $imageName]);
                    }
        
                    
                    PageSection::where('id', $request->input("card_title_text_{$i}_id"))
                        ->update(['value' => $request->input("card_title_text_$i")]);
        
                    
                    PageSection::where('id', $request->input("card_desc_text_{$i}_id"))
                        ->update(['value' => $request->input("card_desc_text_$i")]);
        
                    
                    PageSection::where('id', $request->input("card_link_{$i}_id"))
                        ->update(['value' => $request->input("card_link_$i")]);
                }
        
                return redirect()->back()->with('success', 'Essentials section updated successfully!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error updating essentials section: ' . $e->getMessage());
            }
        }


        elseif ($section === 'counter') {
            $request->validate([
                'car_for_sale' => 'required|numeric|min:0',
                'forum_sections' => 'required|numeric|min:0',
                'visitor_per_day' => 'required|numeric|min:0',
                'verified_dealers' => 'required|numeric|min:0',
            ]);

            PageSection::where('id', $request->car_for_sale_id)
                ->update(['value' => $request->car_for_sale]);

            PageSection::where('id', $request->forum_sections_id)
                ->update(['value' => $request->forum_sections]);

            PageSection::where('id', $request->visitor_per_day_id)
                ->update(['value' => $request->visitor_per_day]);

            PageSection::where('id', $request->verified_dealers_id)
                ->update(['value' => $request->verified_dealers]);

            return redirect()->back()->with('success', 'Counter section updated successfully!');
        }
    }


}
