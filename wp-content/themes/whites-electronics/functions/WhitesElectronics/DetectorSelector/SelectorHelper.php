<?php
namespace WhitesElectronics\DetectorSelector;

class SelectorHelper
{
    public $questions;
    public $answers;
    public $flags;
    public $personalityLevelLookup;

    function __construct()
    {
        $terms = $this->getQuestionsAndAnswerTerms();

        // create flags lookup for bitwise operation and lookups for questions and answers
        $this->flags = array();
        $this->questions = array();
        $this->answers = array();
        $offset = 0;

        foreach ($terms as $term) {
            if ($term->parent === 0) {
                $this->questions[$term->slug] = $term;
                continue;
            }

            $this->answers[$term->parent][] = $term;

            // create flag lookup for answers
            $this->flags[$term->slug] = 1 << $offset++;
        }
        
        // WPML translated slugs for personality level lookups
        $notMuch = get_term_by('slug', 'not-much', 'detector-selector-questions');
        $somewhat = get_term_by('slug', 'somewhat', 'detector-selector-questions');
        $very = get_term_by('slug', 'very', 'detector-selector-questions');
        $monthly = get_term_by('slug', 'monthly', 'detector-selector-questions');
        $weekly = get_term_by('slug', 'weekly', 'detector-selector-questions');
        $notAsOften = get_term_by('slug', 'not-as-often', 'detector-selector-questions');

        // build personality level lookups
        $this->personalityLevelLookup = array(
            $this->flags[$notMuch->slug] | $this->flags[$monthly->slug] => 'Casual',
            $this->flags[$notMuch->slug] | $this->flags[$weekly->slug] => 'Serious',
            $this->flags[$notMuch->slug] | $this->flags[$notAsOften->slug] => 'Casual',
            $this->flags[$somewhat->slug] | $this->flags[$notAsOften->slug] => 'Casual',
            $this->flags[$somewhat->slug] | $this->flags[$monthly->slug] => 'Serious',
            $this->flags[$somewhat->slug] | $this->flags[$weekly->slug] => 'Professional',
            $this->flags[$very->slug] | $this->flags[$notAsOften->slug] => 'Serious',
            $this->flags[$very->slug] | $this->flags[$monthly->slug] => 'Professional',
            $this->flags[$very->slug] | $this->flags[$weekly->slug] => 'Professional',
        );
    }

    private function getQuestionsAndAnswerTerms()
    {
        // pull questions from taxonomy
        $questions_query_args = array(
            'hierarchical' => true,
            'hide_empty' => false
        );

        return get_terms('detector-selector-questions', $questions_query_args);
    }

    // function to get terms value
    public function getFlagsForTerms(&$terms)
    {
        $result = 0;

        if(is_array($terms)) {
            foreach ($terms as $term) {
                if (array_key_exists($term->slug, $this->flags)) {
                    $result = $result | $this->flags[$term->slug];
                }
            }
        }
        else {
            $result = $this->flags[$terms->slug];
        }

        return $result;
    }
}

