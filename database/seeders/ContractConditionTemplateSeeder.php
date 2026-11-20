<?php

namespace Database\Seeders;

use App\Models\ContractConditionTemplate;
use Illuminate\Database\Seeder;

class ContractConditionTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $clauses = [
            ['title'=>'No Unauthorized STL Distribution','description'=>'The recipient shall not copy, distribute, publish, sublicense or share source STL/design files except to the extent expressly authorized in this agreement.','condition_type'=>'intellectual_property'],
            ['title'=>'No Unauthorized Commercial Reproduction','description'=>'The recipient shall not manufacture or commercially sell covered designs beyond the permissions expressly granted under this agreement.','condition_type'=>'intellectual_property'],
            ['title'=>'Confidentiality','description'=>'The recipient shall protect confidential business, design, pricing and customer information and shall not disclose it except as permitted in writing.','condition_type'=>'confidentiality'],
            ['title'=>'No Transfer of Franchise Rights','description'=>'The franchisee shall not assign, sublicense or transfer franchise rights without prior written approval from LayerLoop.','condition_type'=>'franchise'],
            ['title'=>'Brand Guidelines','description'=>'The franchisee shall use LayerLoop names, marks and approved brand assets only in accordance with the current written brand guidelines.','condition_type'=>'brand'],
            ['title'=>'Written Approval for Territory Changes','description'=>'Any change to the approved territory or exclusivity scope must be documented and signed by the parties.','condition_type'=>'territory'],
        ];

        foreach ($clauses as $clause) {
            \App\Models\ContractConditionTemplate::firstOrCreate(['title'=>$clause['title']], $clause + ['is_active'=>true]);
        }
    }
}
