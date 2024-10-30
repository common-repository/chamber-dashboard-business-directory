/**
 * Block dependencies
 */

import edit from './edit';

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { dateI18n, format, __experimentalGetSettings } from '@wordpress/date';
import { setState } from '@wordpress/compose';

registerBlockType( 'cdash-bd-blocks/business-category', {
    title: 'Display Business Categories',
    icon: 'category',
    category: 'cd-blocks',
    description: 'The business category block displays the categories on your page.',
    example: {
    },
    supports: {
        // Declare support for block's alignment.
        // This adds support for all the options:
        // left, center, right, wide, and full.
        align: true
    },
    attributes: {
        align: {
            type: 'string',
            default: '',
        },
        cd_block:{
            type: 'string',
            default: 'yes',
        },
        format: {
             type: 'string',
             default: 'list',
        },
        orderby: {
            type: 'string',
            default: 'name',
        },
        order: {
            type: 'string',
            default: 'ASC',
        },
        showcount: {
            type: 'number',
            default: 0,
        },
        showCountToggle: {
            type: 'boolean',
            default: false,
        },
        hierarchical: {
            type: 'number',
            default: 1,
        },
        hierarchyToggle: {
            type: 'boolean',
            default: true,
        },
        hide_empty: {
            type: 'number',
            default: 1,
        },
        hideEmptyToggle: {
            type: 'boolean',
            default: true,
        },
        child_of: {
            type: 'number',
            default: 0,
        },
        exclude: {
            type: 'number',
            default: 0,
        },
        excludeCategories: {
            type: 'array',
            default: [],
        },
        depth: {
            type: 'number',
            default: 0
        },
    },
    edit: edit,
    save() {
        // Rendering in PHP
        return null;
    },
});