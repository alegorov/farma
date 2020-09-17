<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use DOMDocument;
use App\Models\Notification;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from FTP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        self::process();
        return 0;
    }

    static private function dom2Array($root)
    {
        $array = [];

        if ($root->hasChildNodes()) {
            $children = $root->childNodes;
            for ($i = 0; $i < $children->length; $i++) {
                $child = $children->item($i);

                $value = self::dom2Array($child);

                $key = $child->localName;

                if ($value) {
                    if (strlen($key)) {
                        $array[$key] = $value;

                        if ($child->hasAttributes()) {
                            foreach ($child->attributes as $attribute) {
                                $array[$key]['__attributes_'][$attribute->name] = $attribute->value;
                            }
                        }
                    } else {
                        $array = $value;

                        if ($child->hasAttributes()) {
                            foreach ($child->attributes as $attribute) {
                                $array['__attributes_'][$attribute->name] = $attribute->value;
                            }
                        }
                    }
                }
            }
        } else {
            $value = trim($root->nodeValue);
            if (strlen($value)) {
                $array['__value_'] = $value;
            }
        }

        return $array;
    }

    private static function filterArrayAttributes($input, $parent_key = '', &$parent_array = [])
    {
        if (!is_array($input)) {
            return $input;
        }

        $array = [];

        foreach ($input as $key => $value) {
            if ($key == '__attributes_') {
                foreach ($value as $attr_key => $attr_value) {
                    $parent_array[$parent_key . '_' . $attr_key] = $attr_value;
                }
            } else {
                $array[$key] = self::filterArrayAttributes($value, $key, $array);
            }
        }

        return $array;
    }

    private static function filterArrayValues($input)
    {
        if (!is_array($input)) {
            return $input;
        }

        $array = [];

        foreach ($input as $key => $value) {
            if (is_array($value) && (count($value) == 1) && array_key_exists('__value_', $value)) {
                $array[$key] = $value['__value_'];
            } else {
                $array[$key] = self::filterArrayValues($value);
            }
        }

        return $array;
    }

    public static function process()
    {
        $conn_id = ftp_connect('ftp.zakupki.gov.ru');

        ftp_login($conn_id, 'free', 'free');

        $contents = ftp_nlist($conn_id, '/fcs_regions/Kaliningradskaja_obl/notifications/currMonth');


        foreach ($contents as $server_file) {
            if (substr($server_file, -8) !== '.xml.zip') {
                continue;
            }

            $zip_file = tempnam(sys_get_temp_dir(), 'ft1');

            ftp_get($conn_id, $zip_file, $server_file, FTP_BINARY);

            $zip = new ZipArchive;

            if ($zip->open($zip_file)) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $file_name = $zip->getNameIndex($i);

                    if (substr($file_name, -4) !== '.xml') {
                        continue;
                    }

                    $xml_string = file_get_contents('zip://' . $zip_file . '#' . $file_name);
                    $dom = new DomDocument();
                    $dom->loadXML($xml_string);

                    $array = self::dom2Array($dom);
                    $array = self::filterArrayAttributes($array);
                    $array = self::filterArrayValues($array);

                    if (isset($array['export']['fcsNotificationEF']['id'])) {
                        $id = $array['export']['fcsNotificationEF']['id'];
                    } elseif (isset($array['export']['fcsNotificationCancel']['id'])) {
                        $id = $array['export']['fcsNotificationCancel']['id'];
                    } else {
                        $id = '';
                    }

                    if (strlen($id)) {
                        $json_data = json_encode($array);

                        Notification::updateOrCreate(
                            compact('id'),
                            compact('json_data')
                        );
                    }
                }

                $zip->close();
            }

            if (file_exists($zip_file)) {
                unlink($zip_file);
            }
        }
    }
}
