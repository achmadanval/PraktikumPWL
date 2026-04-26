<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Post Details")
                ->Description("Fill in the details of the box")
                ->icon(Heroicon::RocketLaunch)
                ->schema([
                    Group::make([    
                        TextInput::make("title")
                            //->required()
                            //->rules('required')
                            //->rules('required | min:3 | max:10 ')
                            ->rules(["required"," min:3" , "max:10 "])
                            //->minLength(5)
                            //->maxLength(10)
                            ->extraInputAttributes(['novalidate' => 'novalidate'])
                            ->validationMessages([
                                'required' => 'Judul Tidak boleh kosong',
                                'min' => 'Judul terlalu pendek',
                                'max' => 'Judul terlalu panjang'
                            ]),
                        TextInput::make("slug")
                            ->required()
                            ->unique(ignoreRecord:true)
                            ->minLength(3)
                            ->validationMessages([
                                "unique" => "slug harus Uniq dan berbeda",
                                "min" => "Slug terlalu pendek, minimal 3 huruf",
                            ]),
                        Select::make("category_id")
                            ->relationship("category","name")
                            ->required()
                            ->preload()
                            ->searchable()
                            ->validationMessages([
                                "required" => "Kategori harus dipilih",
                                
                            ]),
                        ColorPicker::make("color"),
                    ])->columns(2),    
                    MarkdownEditor::make("content"),
                ])->columnSpan(2),
                //RichEditor::make("content"),

                Group::make([
                //Section 2 - Image
                    Section::make("Image Upload")
                    ->icon(Heroicon::VideoCamera)
                    ->schema([
                        FileUpload::make("image")
                        ->required()
                        ->image()
                        ->maxSize(1024)
                        ->disk("public")
                        ->directory("posts")
                        ->validationMessages([
                            "required" => "Gambar harus di isi",
                            "image" => "File harus berupa gambar (jpg, jpeg, png)",
                            "max" => "Ukuran gambar terlalu besar, maksimal 1MB",
                        ]),
                    ]),

                    //Section 3 - Meta
                    Section::make("Meta Information")
                    ->icon(Heroicon::InformationCircle)
                    ->schema([
                        //TagsInput::make("tags"),
                        /*Select::make("tags")
                            ->key('tags_select_input')
                            ->multiple()
                            ->relationship("tags","name")
                            ->preload()
                            ->searchable(),*/
                            
                            
                        Checkbox::make("published"),
                    ]),
                    DatePicker::make("published_at")
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
