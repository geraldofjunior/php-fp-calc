<?php
namespace entities\counted_function;

class CountedFunctionDecorator implements ICountedFunction {
    private CountedFunction $component;

    public function __construct(?CountedFunction $function) {
        if (isset($function)) {
            $this->component = $function;
        }
    }

    public function getName():string {
        return $this->component->getName();
    }

    public function getFunctionPoints():int {
        return $this->component->getFunctionPoints();
    }

    public function getComplexity():int {
        return $this->component->getComplexity();      
    }
}
?>