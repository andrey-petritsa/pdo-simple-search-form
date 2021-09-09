<?php

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
    }



    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->seeInTitle('Поиск');
    }

    public function userCantEnterLessThan3Symbols(AcceptanceTester $I)
    {
        $I->fillField('.search-form__input', 'a');
        $I->click('.search-form__submit');
        $I->see('Для поиска нужно минимум 3 символа');

        $I->fillField('.search-form__input', 'aa');
        $I->click('.search-form__submit');
        $I->see('Для поиска нужно минимум 3 символа');

        $I->fillField('.search-form__input', '');
        $I->click('.search-form__submit');
        $I->see('Для поиска нужно минимум 3 символа');
    }

    public function userGetNoPostsMessageWithNonExistedComment(AcceptanceTester $I)
    {
        $I->fillField('.search-form__input', 'aaaa');
        $I->click('.search-form__submit');
        $I->wait(1);
        $I->see('Не найдено постов с указанным комментарием');
    }

    public function userGetPostsIfHeEntersExistedComment(AcceptanceTester $I)
    {
        $I->fillField('.search-form__input', 'laudanti');
        $I->click('.search-form__submit');
        $I->wait(1);
        $I->see('sunt aut facere repellat provident occaecati excepturi optio reprehenderit');
    }
}
