/**
 * Block dependencies
 */

import edit from './edit';

import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { dateI18n, format, __experimentalGetSettings } from '@wordpress/date';
import { withState } from '@wordpress/compose';
import { setState } from '@wordpress/compose';
//const { withState, setState } = wp.compose;

registerBlockType( 'cdash-bd-blocks/logo-gallery', {
    title: 'Logo Gallery',
    icon: 'format-gallery',
    category: 'cd-blocks',
    description: 'The logo gallery block displays the Business Logos without the name, description or other fields.',
    example: {
    },
    attributes: {
        cd_block:{
            type: 'string',
            default: 'yes',
        },
        postLayout: {
             type: 'string',
             default: 'grid3',
	},
        format: {
            type: 'string',
            default: 'grid3',
        },
        categoryArray:{
            type: 'array',
            default: [],
        },
        category:{
            type: 'string',
            default: '',
        },
        tags:{
            type: 'string',
            default: '',
        },
        membershipLevelArray:{
            type: 'array',
            default: [],
        },
        level:{
            type: 'string',
            default: '',
        },
        displayPostContent:{
            type:Boolean,
            default: true,        
        },
        display:{
            type: 'string',
            default: '',
        },
        text:{
            type: 'string',
            default: 'none',
        },
        singleLinkToggle: {
            type: 'boolean',
            default: true,
        },
        single_link:{
            type: 'string',
            default: 'yes',
        },
        perpage:{
            type: 'number',
            default: -1,
        },
        orderby:{
            type: 'string',
            default: 'title',
        },
        order:{
            type: 'string',
            default: 'asc',
        },
        image:{
            type: 'string',
            default: 'logo',
        },
        membershipStatusArray:{
            type: 'array',
            default: [],
        },
        status:{
            type: 'string',
            default: '',
        },
        image_size:{
            type: 'string',
            default: 'medium',
        },
        alpha:{
            type: 'string',
            default: 'no',
        },
        logo_gallery:{
            type: 'string',
            default: 'yes',
        },
        show_category_filter:{
            type: 'string',
            default: 'no',
        },
        titleFontSize:{
            type: 'number',
            default: 16,
        },
        disablePagination:{
            type: 'boolean',
            default: false,
        },
    },
    edit: edit,
    save() {
        // Rendering in PHP
        return null;
    },
} );