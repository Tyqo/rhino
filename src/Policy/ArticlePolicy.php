<?php
declare(strict_types=1);

namespace Tusk\Policy;

use Authorization\IdentityInterface;
// use Tusk\Model\Entity\Article;

/**
 * Article policy
 */
class AppPolicy
{
    /**
     * Check if $user can add Article
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \Tusk\Model\Entity\Article $article
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Article $article)
    {
		// All logged in users can create articles.
        return true;
    }

    /**
     * Check if $user can edit Article
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \Tusk\Model\Entity\Article $article
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Article $article)
    {
		// logged in users can edit their own articles.
        return $this->isAuthor($user, $article);
    }

    /**
     * Check if $user can delete Article
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \Tusk\Model\Entity\Article $article
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Article $article)
    {
		// logged in users can delete their own articles.
        return $this->isAuthor($user, $article);
    }

    /**
     * Check if $user can view Article
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \Tusk\Model\Entity\Article $article
     * @return bool
     */
    public function canView(IdentityInterface $user, Article $article)
    {
		return $article->user_id === $user->getIdentifier();
    }

	protected function isAuthor(IdentityInterface $user, Article $article)
    {
        return $article->user_id === $user->getIdentifier();
    }
}
