<?php

namespace App\Tools;

use App\User;

class Mention
{
    public $content;

    public $content_parsed;

    public $users = [];

    public $usernames;

    /**
     * Filter the mention usernames.
     * 
     * @return array
     */
    public function getMentionedUsername()
    {
        preg_match_all("/(\S*)\@([^\r\n\s]*)/i", $this->content, $atlist_tmp);

        $usernames = [];

        foreach ($atlist_tmp[2] as $k=>$v) {
            if ($atlist_tmp[1][$k] || strlen($v) >25) {
                continue;
            }
            $usernames[] = $v;
        }
        return array_unique($usernames);
    }

    /**
     * Replace the `@{user}` by the user link
     */
    public function replace()
    {
        $this->content_parsed = $this->content;

        foreach ($this->users as $user) {
            $search = '@' . $user->name;

            $place = '[' . $search . '](' . url('user', $user->name) . ')';

            $this->content_parsed = str_replace($search, $place, $this->content_parsed);
        }
    }

    /**
     * Parse the `@` mention user in content.
     * 
     * @param  string $content
     * @return string
     */
    public function parse($content)
    {
        $this->content = $content;

        $this->usernames = $this->getMentionedUsername();

        count($this->usernames) > 0 && $this->users = User::whereIn('name', $this->usernames)->get();

        $this->replace();

        return $this->content_parsed;
    }
}
