<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\TaxonomiesBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Model for taxons.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class Taxon implements TaxonInterface
{
    /**
     * Taxon id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * The taxonomy of this taxon.
     *
     * @var TaxonomyInterface
     */
    protected $taxonomy;

    /**
     * Parent taxon.
     *
     * @var TaxonInterface
     */
    protected $parent;

    /**
     * Child taxons.
     *
     * @var Collection
     */
    protected $children;

    /**
     * Taxon name.
     *
     * @var string
     */
    protected $name;

    /**
     * Taxon slug.
     *
     * @var string
     */
    protected $slug;

    /**
     * Taxon permalink.
     *
     * @var string
     */
    protected $permalink;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }

    /**
     * {@inheritdoc}
     */
    public function setTaxonomy(TaxonomyInterface $taxonomy = null)
    {
        $this->taxonomy = $taxonomy;

        if (null !== $taxonomy && null === $this->parent) {
            $this->setParent($taxonomy->getRoot());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isRoot()
    {
        return null === $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(TaxonInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermalink()
    {
        if (null !== $this->permalink) {
            return $this->permalink;
        }

        if (null === $this->parent) {
            return $this->slug;
        }

        return $this->permalink = $this->parent->getPermalink().'/'.$this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
    }
}
