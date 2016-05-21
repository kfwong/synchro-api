<?php

use Illuminate\Database\Seeder;
use \Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \App\User::create([
            'ivle_id' => 'e0002704',
            'name' => 'WONG KANG FEI',
            'email' => 'e0002704@u.nus.edu',
            'gender' => 'Male',
            'faculty' => 'School of Computing',
            'first_major' => 'Computer Science (Hons)',
            'second_major' => '',
            'matriculation_year' => 2015,
            'modules_taken' => '{"Results":[{"ModuleCode":"CS1020","ModuleTitle":"Data Structures and Algorithms I","AcadYear":"2015/2016","Semester":"2","SemesterDisplay":"Semester 2"},{"ModuleCode":"CS2100","ModuleTitle":"Computer Organisation","AcadYear":"2015/2016","Semester":"2","SemesterDisplay":"Semester 2"},{"ModuleCode":"GER1000","ModuleTitle":"Quantitative Reasoning","AcadYear":"2015/2016","Semester":"2","SemesterDisplay":"Semester 2"},{"ModuleCode":"GET1031","ModuleTitle":"Computational Thinking","AcadYear":"2015/2016","Semester":"2","SemesterDisplay":"Semester 2"},{"ModuleCode":"MA1101R","ModuleTitle":"Linear Algebra I","AcadYear":"2015/2016","Semester":"2","SemesterDisplay":"Semester 2"},{"ModuleCode":"CP3200","ModuleTitle":"Internship","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"CS1101S","ModuleTitle":"Programming Methodology","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"CS1231","ModuleTitle":"Discrete Structures","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"GET1026","ModuleTitle":"Effective Reasoning","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"ID3123","ModuleTitle":"Interaction Design","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"IS1103","ModuleTitle":"Computing and Society","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"MA1521","ModuleTitle":"Calculus for Computing","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"POY1901","ModuleTitle":"UEM (1) For Poly Graduates","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"POY1902","ModuleTitle":"UEM (2) For Poly Graduates","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"POY1903","ModuleTitle":"UEM (3) For Poly Graduates","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"POY1908","ModuleTitle":"UEM (4) For Poly Graduates","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"},{"ModuleCode":"POY1909","ModuleTitle":"UEM (5) For Poly Graduates","AcadYear":"2015/2016","Semester":"1","SemesterDisplay":"Semester 1"}],"Comments":"Valid login!","LastUpdate":"\/Date(1463230627439+0800)\/","LastUpdate_js":"2016-05-14T20:57:07.4398401+08:00"}'
        ])->save();

        Model::reguard();
    }
}
