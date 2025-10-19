<?php

namespace Providers\Trait;

trait CommonFunctions
{
    public function showToast($message, $type)
    {
        $this->toastMessage = $message;
        $this->toastType = $type;
        $this->showToast = true;
    }
}
